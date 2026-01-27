<x-shop-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
            
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
                    
                    <!-- Left Column: Information -->
                    <div class="lg:col-span-7 space-y-8">
                        
                        <!-- Contact Info (Auto-filled from User) -->
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                             <h2 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h2>
                             <div class="grid grid-cols-1 gap-y-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                     <input type="text" name="customer_name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent sm:text-sm" required>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                     <input type="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-500 shadow-sm sm:text-sm cursor-not-allowed" readonly>
                                 </div>
                             </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                             <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping & Contact Details</h2>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                 <div class="md:col-span-2">
                                     <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                     <input type="tel" name="phone" placeholder="e.g. +91 9876543210" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent sm:text-sm" required>
                                 </div>
                                 <div class="md:col-span-2">
                                     <label class="block text-sm font-medium text-gray-700">Complete Address (House/Building/Street)</label>
                                     <textarea name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent sm:text-sm" placeholder="House No, Building Name, Street" required></textarea>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700">Pincode / Zip Code</label>
                                     <input type="text" name="pincode" placeholder="6-digit Pincode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent sm:text-sm" required>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700">Landmark (Optional)</label>
                                     <input type="text" name="landmark" placeholder="Near Temple / Mall" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent sm:text-sm">
                                 </div>
                             </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                             <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h2>
                             <div class="space-y-4">
                                 <div class="flex items-center">
                                     <input id="cod" name="payment_method" type="radio" value="cod" class="h-4 w-4 border-gray-300 text-accent focus:ring-accent" checked>
                                     <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery (COD)</label>
                                 </div>
                                 <div class="flex items-center">
                                     <input id="stripe" name="payment_method" type="radio" value="stripe" class="h-4 w-4 border-gray-300 text-accent focus:ring-accent">
                                     <label for="stripe" class="ml-3 block text-sm font-medium text-gray-700">Credit / Debit Card (Stripe)</label>
                                 </div>
                                 <div class="flex items-center border-t border-gray-100 pt-4 mt-2">
                                     <input id="razorpay" name="payment_method" type="radio" value="razorpay" class="h-4 w-4 border-gray-300 text-accent focus:ring-accent">
                                     <label for="razorpay" class="ml-3 block text-sm font-medium text-gray-700">Razorpay (UPI, Cards, Netbanking)</label>
                                 </div>
                                 <div class="flex items-center border-t border-gray-100 pt-4 mt-2">
                                     <input id="dummy" name="payment_method" type="radio" value="dummy" class="h-4 w-4 border-gray-300 text-accent focus:ring-accent">
                                     <label for="dummy" class="ml-3 block text-sm font-medium text-gray-700">
                                        <span class="block">Test Gateway (Simulation)</span>
                                        <span class="block text-xs text-gray-500">For testing success/fail flows without real money.</span>
                                     </label>
                                 </div>
                             </div>
                        </div>

                    </div>

                    <!-- Right Column: Order Summary -->
                    <div class="lg:col-span-5 mt-8 lg:mt-0">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                             <ul class="divide-y divide-gray-200">
                                @foreach($cartItems as $item)
                                    <li class="flex py-4">
                                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                             <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : Storage::url($item->product->image_url) }}" class="h-full w-full object-cover object-center">
                                        </div>
                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3>{{ $item->product->name }}</h3>
                                                    <p class="ml-4">₹{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                                </div>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                <p class="text-gray-500">Qty {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <!-- Coupon Code Section -->
                            <div class="border-t border-gray-200 pt-6">
                                @if(session('success'))
                                    <div class="mb-4 text-green-600 text-sm font-medium">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="mb-4 text-red-600 text-sm font-medium">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if($discount > 0)
                                    <div class="flex items-center justify-between mb-4 bg-green-50 p-3 rounded-md border border-green-100">
                                        <div class="flex items-center text-green-700 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd" />
                                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z" />
                                            </svg>
                                            <span>Coupon applied: <strong>{{ session('coupon_code') }}</strong></span>
                                        </div>
                                        <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Remove</button>
                                        </form>
                                    </div>
                                @else
                                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-4">
                                        @csrf
                                        <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">Have a coupon code?</label>
                                        <div class="flex space-x-2">
                                            <input type="text" name="coupon_code" id="coupon_code" placeholder="Enter coupon code" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" required>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Apply
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            
                            <dl class="space-y-4 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600">Subtotal</dt>
                                    <dd class="text-sm font-medium text-gray-900">₹{{ number_format($subtotal, 2) }}</dd>
                                </div>
                                
                                @if($discount > 0)
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-green-600">Discount</dt>
                                    <dd class="text-sm font-medium text-green-600">-₹{{ number_format($discount, 2) }}</dd>
                                </div>
                                @endif

                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt class="text-base font-medium text-gray-900">Total</dt>
                                    <dd class="text-xl font-bold text-gray-900">₹{{ number_format($total, 2) }}</dd>
                                </div>
                            </dl>

                            <button type="submit" class="w-full mt-6 bg-primary border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-shop-layout>

