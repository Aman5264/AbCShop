<x-shop-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Bag <span class="text-gray-500 text-lg font-normal">({{ $cartItems->count() }} Items)</span></h1>

            @if($cartItems->count() > 0)
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                    <!-- Cart Items -->
                    <section class="lg:col-span-8 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <li class="p-6 flex sm:py-8">
                                    <!-- Image -->
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : Storage::url($item->product->image_url) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="h-full w-full object-cover object-center">
                                    </div>

                                    <!-- Details -->
                                    <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h3 class="text-sm">
                                                        <a href="{{ route('shop.show', $item->product_id) }}" class="font-medium text-gray-700 hover:text-gray-900">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="mt-1 flex text-sm">
                                                    <p class="text-gray-500">{{ $item->product->brand ?? 'ABCSHOP' }}</p>
                                                </div>
                                                <p class="mt-1 text-sm font-medium text-gray-900">₹{{ number_format($item->product->price, 2) }}</p>
                                            </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                                <!-- Qty Stepper / Update -->
                                                <form action="{{ route('cart.update', $item->product_id) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    <label for="quantity-{{ $item->product_id }}" class="sr-only">Quantity</label>
                                                    
                                                    <!-- Quantity Selector -->
                                                    <div class="flex items-center border border-gray-300 rounded-md">
                                                        <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="px-2 py-1 text-gray-600 hover:bg-gray-100 transition">-</button>
                                                        <input type="number" 
                                                               name="quantity" 
                                                               id="quantity-{{ $item->product_id }}" 
                                                               value="{{ $item->quantity }}" 
                                                               min="1" 
                                                               max="{{ $item->product->stock }}"
                                                               class="w-12 text-center border-none p-1 text-sm focus:ring-0"
                                                               onchange="this.form.submit()">
                                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-2 py-1 text-gray-600 hover:bg-gray-100 transition">+</button>
                                                    </div>
                                                </form>

                                                <!-- Remove -->
                                                <div class="absolute top-0 right-0">
                                                    <a href="{{ route('cart.remove', $item->product_id) }}" class="-m-2 p-2 inline-flex text-gray-400 hover:text-red-500 transition">
                                                        <span class="sr-only">Remove</span>
                                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                          <path fill-rule="evenodd" d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                            @if ($item->quantity <= $item->product->stock)
                                                <svg class="h-5 w-5 flex-shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                                </svg>
                                                <span>In stock</span>
                                            @else
                                                 <span class="text-red-500">Out of stock</span>
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <!-- Order Summary -->
                    <section class="lg:col-span-4 mt-16 lg:mt-0">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>

                            <dl class="mt-6 space-y-4">
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
                                    <dt class="flex items-center text-sm text-gray-600">
                                        <span>Shipping estimate</span>
                                        <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                            <span class="sr-only">Learn more about how shipping is calculated</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </dt>
                                    <dd class="text-sm font-medium text-gray-900">Free</dd>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt class="text-base font-medium text-gray-900">Order total</dt>
                                    <dd class="text-base font-bold text-gray-900">₹{{ number_format($total, 2) }}</dd>
                                </div>
                            </dl>

                            <div class="mt-6">
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
                                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-6">
                                        @csrf
                                        <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-1">Have a coupon?</label>
                                        <div class="flex space-x-2">
                                            <input type="text" name="coupon_code" id="coupon_code" placeholder="Enter code" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md border-gray-300 focus:ring-accent focus:border-accent sm:text-sm shadow-sm" required>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                Apply
                                            </button>
                                        </div>
                                    </form>
                                @endif

                                <a href="{{ route('checkout.index') }}" class="w-full bg-accent border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-accent flex justify-center items-center transition">
                                    Proceed to Checkout
                                </a>
                            </div>
                            

                        </div>
                    </section>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center h-96 flex flex-col items-center justify-center">
                    <div class="text-gray-200 mb-6">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-24 h-24">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                         </svg>
                    </div>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">Your Bag is Empty</h2>
                    <p class="text-gray-500 mb-8 max-w-sm">Looks like you haven't added anything to your bag yet. Explore our premium collection.</p>
                    <a href="{{ route('shop.index') }}" class="bg-primary text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition shadow-lg">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-shop-layout>
