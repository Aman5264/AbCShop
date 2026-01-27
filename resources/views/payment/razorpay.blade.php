<x-shop-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100 text-center">
            
            <h2 class="text-3xl font-extrabold text-gray-900">Confirm Payment</h2>
            <p class="mt-2 text-sm text-gray-500">Total Amount: {{ $data['currency'] }} {{ number_format($data['amount'] / 100, 2) }}</p>

            <button id="rzp-button1" class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition">
                Pay with Razorpay
            </button>
            
            <form action="{{ route('payment.razorpay.verify') }}" method="POST" id="rzp-verify-form">
                @csrf
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                <input type="hidden" name="payment_id" value="{{ $data['payment_id'] }}">
            </form>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    var options = {
        "key": "{{ $data['key'] }}",
        "amount": "{{ $data['amount'] }}",
        "currency": "{{ $data['currency'] }}",
        "name": "{{ $data['name'] }}",
        "description": "{{ $data['description'] }}",
        "order_id": "{{ $data['razorpay_order_id'] }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('rzp-verify-form').submit();
        },
        "prefill": {
            "name": "{{ $data['prefill']['name'] }}",
            "email": "{{ $data['prefill']['email'] }}",
            "contact": "{{ $data['prefill']['contact'] }}"
        },
        "theme": {
            "color": "{{ $data['theme']['color'] }}"
        }
    };
    var rzp1 = new Razorpay(options);
    
    // Auto click to open
    window.onload = function() {
        rzp1.open();
    };

    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
    </script>
</x-shop-layout>

