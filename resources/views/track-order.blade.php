<x-shop-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Track Your Order</h1>
                <p class="mt-2 text-gray-600">Enter your order details to check the status</p>
            </div>

            <!-- Tracking Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8">
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        {{ $errors->first('error') ?? 'Please check your information and try again.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('track.order') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="order_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Order ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="order_id" 
                                   id="order_id" 
                                   value="{{ old('order_id') }}"
                                   class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="e.g., ORD-20260125-ABC123"
                                   required>
                            @error('order_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                You can find your Order ID in the confirmation email we sent you.
                            </p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="your.email@example.com"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Enter the email address you used when placing the order.
                            </p>
                        </div>

                        <button type="submit" 
                                class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Track Order
                        </button>
                    </form>
                </div>

                <!-- Help Section -->
                <div class="bg-gray-50 px-6 py-4 sm:px-8 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Need help?</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Order ID can be found in your confirmation email</li>
                        <li>• Make sure to use the email address associated with your order</li>
                        <li>• Contact support if you're having trouble: support@shop.com</li>
                    </ul>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Have an account? 
                    <a href="{{ route('orders.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        View all your orders
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-shop-layout>
