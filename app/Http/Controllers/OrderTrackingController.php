<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function showForm()
    {
        $userOrders = [];
        if (auth()->check()) {
            $userOrders = Order::where('user_id', auth()->id())
                ->with(['items.product', 'payment'])
                ->latest()
                ->get();
        }

        return view('track-order', compact('userOrders'));
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|string',
            'email' => 'required|email',
        ]);

        // Find order by ID or order_number and verify email matches via user relationship
        $orderQuery = Order::whereHas('user', function($query) use ($validated){
            $query->where('email', $validated['email']);
        });

        if (is_numeric($validated['order_id'])) {
            $orderQuery->where('id', $validated['order_id']);
        } else {
            $orderQuery->where('order_number', $validated['order_id']);
        }

        $order = $orderQuery->with(['items.product', 'payment', 'user'])->first();

        if (!$order) {
            return back()->withErrors([
                'error' => 'Order not found. Please check your Order ID and Email address.'
            ])->withInput();
        }

        return view('order-status', compact('order'));
    }
}
