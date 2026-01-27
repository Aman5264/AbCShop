<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Http\Request;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripePaymentService implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function initiate(array $data)
    {
        // 1. Create Payment Record (Pending)
        $payment = Payment::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'currency' => 'USD',
            'payment_method' => 'stripe',
            'payment_gateway' => 'stripe',
            'status' => 'pending',
            'transaction_id' => null, // Will be updated with Session ID or Intent ID later
        ]);

        // 2. Create Stripe Checkout Session
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $this->formatLineItems($data['items']),
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'payment_id' => $payment->id,
                'user_id' => $data['user_id'],
            ],
            'customer_email' => $data['customer_email'] ?? null,
        ]);

        // 3. Update Payment with Session ID
        $payment->update([
            'stripe_session_id' => $checkoutSession->id,
            'gateway_response' => json_encode($checkoutSession)
        ]);

        return $checkoutSession->url;
    }

    public function verify(Request $request)
    {
        // Webhook verification logic
        $payload = @file_get_contents('php://input');
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            throw new \Exception('Invalid Payload');
        } catch(SignatureVerificationException $e) {
            // Invalid signature
            throw new \Exception('Invalid Signature');
        }

        return $event;
    }
    
    protected function formatLineItems($items)
    {
        $lineItems = [];
        foreach($items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->product->price * 100, // cents
                ],
                'quantity' => $item->quantity,
            ];
        }
        return $lineItems;
    }
}
