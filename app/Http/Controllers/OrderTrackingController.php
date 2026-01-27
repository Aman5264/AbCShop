<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function showForm()
    {
        return view('track-order');
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'email' => 'required|email',
        ]);

        // Find order by ID and verify email matches via user relationship
        $order = Order::where('id', $validated['order_id'])
            ->whereHas('user', function($query) use ($validated){
                $query->where('email', $validated['email']);
            })
            ->with(['items.product', 'payment', 'user'])
            ->first();

        if (!$order) {
            return back()->withErrors([
                'error' => 'Order not found. Please check your Order ID and Email address.'
            ])->withInput();
        }

        return view('order-status', compact('order'));
    }
}
