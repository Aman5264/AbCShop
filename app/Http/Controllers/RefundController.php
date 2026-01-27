<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Only delivered orders can be refunded.');
        }

        // Check if refund already exists
        if ($order->refunds()->exists()) {
             return back()->with('error', 'A refund request already exists for this order.');
        }

        RefundRequest::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Refund request submitted successfully.');
    }
}
