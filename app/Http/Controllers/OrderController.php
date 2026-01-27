<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // List user orders
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->findOrFail($id);
            
        return view('orders.show', compact('order'));
    }

    // Cancel order
    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        
        // Optional: Restore stock logic here if implemented
        
        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}
