<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();
        
        if($cartItems->isEmpty()) {
             return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $total = $this->cartService->total();
        $subtotal = $this->cartService->subtotal();
        $discount = $this->cartService->getDiscount();

        return view('checkout', compact('cartItems', 'total', 'subtotal', 'discount'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'pincode' => 'required|string|max:10',
            'landmark' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cod,stripe,razorpay,dummy',
        ]);
        
        // 1. Store Shipping Info in Session for later Order Creation
        $shippingInfo = [
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'landmark' => $request->landmark,
            'full_address' => sprintf(
                "%s\nPincode: %s\nLandmark: %s\nPhone: %s",
                $request->address,
                $request->pincode,
                $request->landmark ?? 'N/A',
                $request->phone
            )
        ];
        session(['checkout_shipping' => $shippingInfo]);

        // 2. COD Bypass
        if ($request->payment_method === 'cod') {
             return $this->processCOD($shippingInfo);
        }

        // 3. Dummy Payment Initiation
        if ($request->payment_method === 'dummy') {
            $dummyService = new \App\Services\Payment\DummyPaymentService();
            $url = $dummyService->initiate([
                'user_id' => auth()->id(),
                'amount' => $this->cartService->total(),
            ]);
            return redirect($url);
        }

        // 4. Stripe Payment Initiation
        if ($request->payment_method === 'stripe') {
            try {
                $stripeService = new \App\Services\Payment\StripePaymentService();
                
                $url = $stripeService->initiate([
                    'user_id' => auth()->id(),
                    'amount' => $this->cartService->total(),
                    'items' => $this->cartService->getItems(),
                    'customer_email' => auth()->user()->email,
                ]);
                return redirect($url);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Stripe Initiation Failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Payment initialization failed. Please try a different method or contact support.');
            }
        }

        // 5. Razorpay Payment Initiation
        if ($request->payment_method === 'razorpay') {
             try {
                $razorpayService = new \App\Services\Payment\RazorpayPaymentService();
                $data = $razorpayService->initiate([
                    'user_id' => auth()->id(),
                    'amount' => $this->cartService->total(),
                ]);
                
                // Return view with Razorpay script
                return view('payment.razorpay', compact('data'));

             } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Razorpay Initiation Failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Razorpay error: ' . $e->getMessage());
             }
        }
    }

    // --- Razorpay Verify ---
    public function razorpayVerify(Request $request) {
        $request->validate([
             'razorpay_payment_id' => 'required',
             'razorpay_order_id' => 'required',
             'razorpay_signature' => 'required',
             'payment_id' => 'required|exists:payments,id' // Local payment record ID passed via form
        ]);

        $payment = Payment::findOrFail($request->payment_id);
        
        // Security: Ensure Payment belongs to User
        if ($payment->user_id !== auth()->id()) abort(403);

        $razorpayService = new \App\Services\Payment\RazorpayPaymentService();
        
        try {
            $isValid = $razorpayService->verify($request);
            
            if ($isValid) {
                 // Update Payment
                 $payment->update([
                     'status' => 'paid',
                     'razorpay_payment_id' => $request->razorpay_payment_id,
                     'razorpay_signature' => $request->razorpay_signature,
                 ]);

                 // Retrieve Shipping Info (from Session)
                 $shippingInfo = session('checkout_shipping');
                 
                 // Create Order
                 $order = $this->createOrder($shippingInfo, 'razorpay', 'paid');
                 
                 // Link Payment
                 $payment->update(['order_id' => $order->id]);
                 
                 // Clear session
                 session()->forget('checkout_shipping');
                 
                 // Email
                 \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\OrderConfirmationMail($order));

                 return redirect()->route('payment.success', ['order_id' => $order->id]);
            } else {
                 $payment->update(['status' => 'failed']);
                 return redirect()->route('checkout.index')->with('error', 'Payment verification failed.');
            }
        
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Razorpay Verify Error: ' . $e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'Error verifying payment.');
        }
    }

    protected function processCOD($shippingInfo)
    {
        // COD logic to create order immediately
        // reuse createOrderLogic here...
        // For brevity, let's keep it consistent:
        $order = $this->createOrder($shippingInfo, 'cod', 'pending');
         \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\OrderConfirmationMail($order));
        return redirect()->route('payment.success', ['order_id' => $order->id]);
    }
    
    // --- Dummy Flow Methods ---

    public function dummyShow(\App\Models\Payment $payment)
    {
        if ($payment->user_id !== auth()->id() || $payment->status !== 'pending') {
            abort(403);
        }
        return view('payment.dummy', compact('payment'));
    }

    public function dummyProcess(\App\Models\Payment $payment, Request $request)
    {
        $status = $request->input('status');
        $dummyService = new \App\Services\Payment\DummyPaymentService();
        $success = $dummyService->processSimulation($payment, $status);

        if ($success) {
            // Retrieve shipping info
            $shippingInfo = session('checkout_shipping');
            if (!$shippingInfo) {
                return redirect()->route('checkout.index')->with('error', 'Session expired. Please try again.');
            }

            // Create Order
            $order = $this->createOrder($shippingInfo, 'dummy', 'paid');
            
            // Link Payment to Order
            $payment->update(['order_id' => $order->id]);

            // Clear Cart and Session
            session()->forget('checkout_shipping');

            // Send Email
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\OrderConfirmationMail($order));

            return redirect()->route('payment.success', ['order_id' => $order->id]);
        }

        return redirect()->route('checkout.index')->with('error', 'Payment failed. Please try again.');
    }

    // Shared Order Creation Logic
    protected function createOrder($shippingInfo, $method, $paymentStatus)
    {
        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->total();
        
        DB::beginTransaction();
        try {
             // Validate Stock again
             foreach($cartItems as $item) {
                 if ($item->product->stock < $item->quantity) {
                     throw new \Exception("Product {$item->product->name} is out of stock.");
                 }
             }

             $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $shippingInfo['customer_name'],
                'shipping_address' => $shippingInfo['full_address'],
                'total_price' => $total,
                'status' => 'pending', // Order itself is pending (processing)
                'payment_method' => $method,
                'payment_status' => $paymentStatus,
            ]);

            foreach($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            $this->cartService->clear();
            
            DB::commit();
            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Keep existing success/cancel methods...
    public function success(Request $request)
    {
        $order = Order::findOrFail($request->query('order_id'));
        // Security check
         if ($order->user_id !== auth()->id()) abort(403);
        return view('payment.success', compact('order'));
    }

    public function cancel() { /* ... */ }
}
