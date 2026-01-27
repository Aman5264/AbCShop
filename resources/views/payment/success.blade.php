<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center py-12">
                <div class="mb-8 text-green-500">
                    <i class="fas fa-check-circle text-8xl"></i>
                </div>
                
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Order Placed Successfully!</h1>
                <p class="text-xl text-gray-600 mb-8">Thank you for your purchase. Your order number is <span class="font-bold text-indigo-600">#{{ $order->id }}</span>.</p>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-left mb-8">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Order Details</h3>
                    <div class="grid grid-cols-2 gap-4 text-gray-600">
                        <div>
                            <span class="block text-sm text-gray-400">Payment Method</span>
                            <span class="font-medium capitalize">{{ $order->payment_method }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-400">Total Amount</span>
                            <span class="font-medium text-indigo-600">₹{{ number_format($order->total_price, 2) }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="block text-sm text-gray-400">Shipping To</span>
                            <span class="font-medium">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center gap-4">
                    <a href="{{ route('orders.index') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-200 transition">
                        View My Orders
                    </a>
                    <a href="{{ route('shop.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

