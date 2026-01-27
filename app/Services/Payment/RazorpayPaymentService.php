<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class RazorpayPaymentService implements PaymentGatewayInterface
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function initiate(array $data)
    {
        // 1. Create Razorpay Order
        // Amount is in paise
        $orderData = [
            'receipt'         => 'rcpt_' . Str::random(10),
            'amount'          => $data['amount'] * 100, 
            'currency'        => 'USD', // Ideally convert to INR or use USD if supported
            'payment_capture' => 1 // Auto capture
        ];

        $razorpayOrder = $this->api->order->create($orderData);

        // 2. Create Local Payment Record
        $payment = Payment::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'currency' => 'USD',
            'payment_method' => 'razorpay',
            'payment_gateway' => 'razorpay',
            'status' => 'pending',
            'razorpay_order_id' => $razorpayOrder['id'],
            'gateway_response' => json_encode($razorpayOrder->toArray())
        ]);

        // 3. Return Data for View
        return [
            'payment_id' => $payment->id,
            'razorpay_order_id' => $razorpayOrder['id'],
            'amount' => $orderData['amount'],
            'key' => env('RAZORPAY_KEY'),
            'currency' => 'USD',
            'name' => 'ABCSHOP', // Configurable
            'description' => 'Order payment',
            'prefill' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'contact' => '' // phone
            ],
            'theme' => [
                'color' => '#F37254'
            ]
        ];
    }

    public function verify(Request $request)
    {
        // Verify Signature
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }
}
