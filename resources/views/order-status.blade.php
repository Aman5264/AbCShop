<x-shop-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Back Button -->
            <div class="mb-6">
                <a href="{{ route('track.order.form') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Track Another Order
                </a>
            </div>

            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
                        <p class="mt-1 text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                            @if($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                            @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Order Progress</h2>
                
                <div class="relative">
                    <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>
                    
                    <!-- Timeline Items -->
                    @php
                        $statuses = [
                            'pending' => ['label' => 'Order Placed', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            'processing' => ['label' => 'Processing', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'shipped' => ['label' => 'Shipped', 'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
                            'delivered' => ['label' => 'Delivered', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
                        ];
                        
                        $currentIndex = array_search($order->status, array_keys($statuses));
                        $isCancelled = $order->status === 'cancelled';
                    @endphp
                    
                    @foreach($statuses as $key => $status)
                        @php
                            $index = array_search($key, array_keys($statuses));
                            $isCompleted = !$isCancelled && $index <= $currentIndex;
                            $isCurrent = !$isCancelled && $key === $order->status;
                        @endphp
                        
                        <div class="relative flex items-start mb-8 last:mb-0">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $isCompleted ? 'bg-indigo-600' : 'bg-gray-200' }} relative z-10">
                                @if($isCompleted)
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1 {{ $isCurrent ? 'font-semibold' : '' }}">
                                <p class="text-sm {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                                    {{ $status['label'] }}
                                </p>
                                @if($isCurrent && !$isCancelled)
                                    <p class="mt-1 text-xs text-indigo-600">Current status</p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if($isCancelled)
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-600 relative z-10">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1 font-semibold">
                                <p class="text-sm text-red-600">Order Cancelled</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                <div class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <div class="py-4 first:pt-0 last:pb-0 flex items-center">
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : Storage::url($item->product->image_url) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="h-full w-full object-cover object-center">
                            </div>
                            <div class="ml-4 flex flex-1 flex-col">
                                <div class="flex justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="ml-4 text-sm font-medium text-gray-900">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        @if($order->shipping_landmark)
                            <p>Landmark: {{ $order->shipping_landmark }}</p>
                        @endif
                        <p>{{ $order->shipping_pincode }}</p>
                        <p class="pt-2">{{ $order->customer_phone }}</p>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Payment Method</dt>
                            <dd class="font-medium text-gray-900">{{ strtoupper($order->payment_method) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Payment Status</dt>
                            <dd>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $order->payment?->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->payment?->status ?? 'pending') }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex justify-between pt-4 border-t border-gray-200">
                            <dt class="font-semibold text-gray-900">Total Amount</dt>
                            <dd class="font-bold text-lg text-gray-900">₹{{ number_format($order->total_price, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-blue-800">Need Help?</h3>
                        <p class="mt-1 text-sm text-blue-700">
                            If you have questions about your order, please contact our support team at 
                            <a href="mailto:support@shop.com" class="font-medium underline">support@shop.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>
