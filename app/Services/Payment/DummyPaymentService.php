<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Str;

class DummyPaymentService implements PaymentGatewayInterface
{
    public function initiate(array $data)
    {
        // 1. Create Payment Record (Pending)
        $payment = Payment::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'currency' => 'USD',
            'payment_method' => 'dummy',
            'payment_gateway' => 'dummy',
            'transaction_id' => 'TXN_' . strtoupper(Str::random(12)),
            'status' => 'pending',
            'gateway_response' => json_encode(['initiated_at' => now()])
        ]);

        // 2. Return Redirect URL to Dummy Payment Page
        return route('payment.dummy.show', ['payment' => $payment->id]);
    }

    public function verify(Request $request)
    {
        // Not used for dummy usually, but good for standardization
    }

    public function processSimulation(Payment $payment, $status)
    {
        if ($status === 'success') {
            $payment->update([
                'status' => 'completed',
                'gateway_response' => json_encode(['completed_at' => now(), 'simulated_status' => 'success'])
            ]);
            return true;
        }

        $payment->update([
            'status' => 'failed',
            'gateway_response' => json_encode(['failed_at' => now(), 'reason' => 'User simulated failure'])
        ]);
        return false;
    }
}
