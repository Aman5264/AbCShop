<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\CartService;

class ShopController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // 1. List Products (Home Page)
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->has('category')) {
            $slug = $request->input('category');
            $query->whereHas('categories', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $products = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $banners = \App\Models\Banner::where('is_active', true)->orderBy('sort_order')->get();

        return view('shop', compact('products', 'categories', 'banners'));
    }

    // 1.1 Category Page
    public function category($slug)
    {
        $currentCategory = Category::where('slug', $slug)->firstOrFail();
        
        $query = Product::where('is_active', true)
            ->whereHas('categories', function($q) use ($currentCategory) {
                $q->where('categories.id', $currentCategory->id);
            });

        $products = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        // We typically don't show the main homepage banners on category pages, unless specified.
        $banners = collect(); 

        return view('shop', compact('products', 'categories', 'banners', 'currentCategory'));
    }

    // 1.5 Product Details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        $relatedProducts = Product::where('id', '!=', $id)
            ->whereHas('categories', function($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->take(4)
            ->get();
        
        $product->load(['reviews' => function($q) {
            $q->where('is_approved', true)->latest();
        }, 'reviews.user']);

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    // 2. Add item to Cart
    public function addToCart(Request $request, $id)
    {
        try {
            $quantity = $request->input('quantity', 1);
            $this->cartService->add($id, $quantity);

            if ($request->has('buy_now')) {
                return redirect()->route('checkout.index');
            }
            
            return redirect()->back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // 3. View the Cart
    public function cart()
    {
        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->total();
        $subtotal = $this->cartService->subtotal();
        $discount = $this->cartService->getDiscount();
        
        return view('cart', compact('cartItems', 'total', 'subtotal', 'discount')); 
    }
}