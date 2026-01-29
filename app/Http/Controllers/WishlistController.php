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
        if (!Auth::check()) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Please login first.'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // check if already exists
        $wishlist = $user->wishlists()->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Product removed from wishlist.';
        } else {
            $user->wishlists()->create([
                'product_id' => $productId
            ]);
            $status = 'added';
            $message = 'Product added to wishlist.';
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => $user->wishlists()->count()
            ]);
        }

        return back()->with('success', $message);
    }
}
