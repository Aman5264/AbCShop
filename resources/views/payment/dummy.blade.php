<x-shop-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Secure Payment</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Merchant: <span class="font-bold text-gray-800">ABCSHOP</span>
                </p>
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Transaction Amount</p>
                     <p class="text-3xl font-bold text-gray-900">₹{{ number_format($payment->amount, 2) }}</p>
                     <p class="text-xs text-gray-400 mt-1">ID: {{ $payment->transaction_id }}</p>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-2 bg-white text-sm text-gray-500">
                            Simulate Payment Gateway
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <form action="{{ route('payment.dummy.process', $payment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="success">
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition shadow-md hover:shadow-lg">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-green-500 group-hover:text-green-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            Success
                        </button>
                    </form>

                    <form action="{{ route('payment.dummy.process', $payment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="failed">
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition shadow-md hover:shadow-lg">
                             <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-red-500 group-hover:text-red-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            Failure
                        </button>
                    </form>
                </div>
                
                <p class="text-center text-xs text-gray-400 mt-4">
                    This is a secure simulation environment. No real money will be deducted.
                </p>
            </div>
        </div>
    </div>
</x-shop-layout>

