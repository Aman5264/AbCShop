<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Auth::user()->wishlists()->with('product')->latest()->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle($productId)
    {
        $user = Auth::user();
        
        // check if already exists
        $wishlist = $user->wishlists()->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Product removed from wishlist.');
        } else {
            $user->wishlists()->create([
                'product_id' => $productId
            ]);
            return back()->with('success', 'Product added to wishlist.');
        }
    }
}
