<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(\App\Services\CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Update Item Quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            $this->cartService->updateQuantity($id, $request->quantity);
            return redirect()->back()->with('success', 'Cart updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Remove Item
    public function remove($id)
    {
        $this->cartService->remove($id);
        return redirect()->back()->with('success', 'Item removed.');
    }

    // Clear Cart
    public function clear()
    {
        $this->cartService->clear();
        return redirect()->back()->with('success', 'Cart cleared.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        try {
            $this->cartService->applyCoupon($request->coupon_code);
            return redirect()->back()->with('success', 'Coupon applied successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function removeCoupon()
    {
        $this->cartService->removeCoupon();
        return redirect()->back()->with('success', 'Coupon removed.');
    }
}
