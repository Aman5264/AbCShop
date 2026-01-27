<x-account-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Order #{{ $order->id }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Placed on {{ $order->created_at->format('F d, Y') }}</p>
                </div>
                <div>
                     @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'shipped' => 'bg-indigo-100 text-indigo-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $class }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 capitalize">{{ $order->payment_method }} ({{ $order->payment_status }})</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Items -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ordered Items</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                @foreach($order->items as $item)
                    <li class="p-4 sm:p-6 flex items-center">
                         <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                             <!-- Ideally snapshot image, falling back to live product -->
                             <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : Storage::url($item->product->image_url) }}" 
                                  class="h-full w-full object-cover object-center">
                         </div>
                         <div class="ml-4 flex-1">
                             <div class="flex justify-between font-medium text-gray-900">
                                 <h3>{{ $item->product->name }}</h3>
                                 <p>₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                             </div>
                             <p class="text-gray-500 text-sm mt-1">Qty {{ $item->quantity }} x ₹{{ number_format($item->price, 2) }}</p>
                         </div>
                    </li>
                @endforeach
            </ul>
             <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                  <div class="text-lg font-bold text-gray-900">Total: ₹{{ number_format($order->total_price, 2) }}</div>
             </div>
        </div>
        
        <!-- Actions -->
        @if($order->status === 'pending')
            <div class="flex justify-end">
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                    @csrf
                    <button type="submit" class="bg-white border border-red-300 text-red-700 hover:bg-red-50 px-4 py-2 rounded-md text-sm font-medium shadow-sm">
                        Cancel Order
                    </button>
                </form>
            </div>
        @endif

        @if($order->status === 'delivered')
            <div class="flex justify-end mt-4">
                @if($order->refunds->isEmpty())
                    <button type="button" onclick="document.getElementById('refundModal').classList.remove('hidden')" class="bg-indigo-600 border border-transparent text-white hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium shadow-sm">
                        Request Refund
                    </button>
                    
                    <!-- Refund Modal -->
                    <div id="refundModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <form action="{{ route('refund.store', $order->id) }}" method="POST">
                                @csrf
                                <div>
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100">
                                        <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-5">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Request Refund</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 mb-4">Please provide a reason for your refund request.</p>
                                            <textarea name="reason" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Item damaged, wrong size, etc." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                                        Submit Request
                                    </button>
                                    <button type="button" onclick="document.getElementById('refundModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <span class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-50">
                        Refund Status: {{ ucfirst($order->refunds->first()->status) }}
                        @if($order->refunds->first()->status === 'approved' && $order->refunds->first()->pickup_date)
                            <span class="ml-2 text-indigo-600 font-bold">
                                (Pickup: {{ \Carbon\Carbon::parse($order->refunds->first()->pickup_date)->format('M d, Y') }})
                            </span>
                        @endif
                    </span>
                @endif
            </div>
        @endif
    </div>
</x-account-layout>

