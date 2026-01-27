<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartService
{
    protected $cartInstance = null;

    /**
     * Get Cart (Optionally create if it doesn't exist)
     */
    public function getCart(bool $create = true)
    {
        if ($this->cartInstance !== null) {
            return $this->cartInstance;
        }

        if (Auth::check()) {
            $userId = Auth::id();
            if ($create) {
                $this->cartInstance = Cart::firstOrCreate(['user_id' => $userId]);
            } else {
                $this->cartInstance = Cart::where('user_id', $userId)->first();
            }
        } else {
            $sessionId = Session::getId();
            if ($create) {
                $this->cartInstance = Cart::firstOrCreate(['session_id' => $sessionId]);
            } else {
                $this->cartInstance = Cart::where('session_id', $sessionId)->first();
            }
        }

        return $this->cartInstance;
    }

    /**
     * Add Item to Cart
     */
    public function add(int $productId, int $quantity = 1, bool $replace = false)
    {
        $cart = $this->getCart(true); // Always create if adding items
        $product = Product::findOrFail($productId);
        // ... (remaining logic unchanged)
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $newQuantity = $replace ? $quantity : $item->quantity + $quantity;
            
            if ($newQuantity > $product->stock) {
                 throw new \Exception("Sorry, only {$product->stock} items remaining in stock.");
            }
            // Prevent zero or negative
            if ($newQuantity <= 0) {
                $item->delete();
                return;
            }
            
            $item->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }
        
        Session::forget('cart_count');
    }

    /**
     * Update Quantity
     */
    public function updateQuantity(int $productId, int $quantity)
    {
        // Wrapper for add with replace=true
        $this->add($productId, $quantity, true);
    }

    /**
     * Remove Item
     */
    public function remove(int $productId)
    {
        $cart = $this->getCart(false); // Only if exists
        if (!$cart) return;

        $cart->items()->where('product_id', $productId)->delete();
        Session::forget('cart_count');
        
        // Cleanup empty carts (optional)
        if ($cart->items()->count() === 0) {
            // $cart->delete(); 
        }
    }

    /**
     * Get Items
     */
    public function getItems()
    {
        $cart = $this->getCart(false);
        if (!$cart) return collect();
        
        return $cart->items()->with('product')->get();
    }

    /**
     * Calculate Subtotal
     */
    public function subtotal()
    {
        return $this->getItems()->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Get Applied Coupon Discount
     */
    public function getDiscount()
    {
        if (!Session::has('coupon_code')) {
            return 0;
        }

        $code = Session::get('coupon_code');
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>=', now());
            })
            ->first();

        if (!$coupon) {
            Session::forget('coupon_code');
            return 0;
        }

        $subtotal = $this->subtotal();

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return 0;
        }

        if ($coupon->type === 'fixed') {
            return min($coupon->value, $subtotal);
        }

        if ($coupon->type === 'percent') {
            return $subtotal * ($coupon->value / 100);
        }

        return 0;
    }

    /**
     * Calculate Final Total
     */
    public function total()
    {
        return max(0, $this->subtotal() - $this->getDiscount());
    }

    public function applyCoupon($code)
    {
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            throw new \Exception('Invalid coupon code.');
        }

        if ($coupon->expiry_date && Carbon::parse($coupon->expiry_date)->isPast()) {
            throw new \Exception('This coupon has expired.');
        }

        if ($coupon->min_order_amount && $this->subtotal() < $coupon->min_order_amount) {
            throw new \Exception('Minimum order amount of ₹' . number_format($coupon->min_order_amount, 2) . ' required.');
        }

        Session::put('coupon_code', $code);
    }

    public function removeCoupon()
    {
        Session::forget('coupon_code');
    }

    /**
     * Count Items
     */
    public function count(): int
    {
        if (Session::has('cart_count')) {
            return Session::get('cart_count');
        }

        $cart = $this->getCart(false); // DO NOT CREATE CART FOR COUNT
        if (!$cart) return 0;

        $count = (int) $cart->items()->sum('quantity');
        Session::put('cart_count', $count);
        return $count;
    }

    /**
     * Clear Cart
     */
    public function clear()
    {
        $this->getCart()->items()->delete();
        Session::forget('cart_count');
    }

    /**
     * Merge Guest Cart (Login Listener)
     */
    public function mergeGuestCart()
    {
        $sessionId = Session::getId();
        $guestCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();

        if (!$guestCart) return;

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($guestCart->items as $guestItem) {
            $existing = $userCart->items()->where('product_id', $guestItem->product_id)->first();
            
            if ($existing) {
                // Determine max additive quantity allowed by stock
                $product = $existing->product; 
                // Need to reload product to check stock properly if eager loaded outdated
                $potentialQty = $existing->quantity + $guestItem->quantity;
                $allowedQty = min($potentialQty, $product->stock);
                
                $existing->update(['quantity' => $allowedQty]);
            } else {
                // Re-link to user cart
                $guestItem->update(['cart_id' => $userCart->id]);
            }
        }
        
        // Delete the old guest cart shell
        $guestCart->delete();
        Session::forget('cart_count');
    }
}
