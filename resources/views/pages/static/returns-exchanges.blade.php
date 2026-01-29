<x-shop-layout>
    <x-slot name="title">Returns & Exchanges - ABCSHOP</x-slot>
    
    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-12">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8 border-b border-gray-100 pb-4">Returns & Exchanges Policy</h1>
                    
                    <div class="prose prose-indigo max-w-none text-gray-600 space-y-6">
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Our Guarantee</h2>
                            <p>We want you to be completely satisfied with your purchase. If you're not happy with your order, we're here to help.</p>
                        </section>

                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Return Window</h2>
                            <p>You have <strong>30 days</strong> from the date of delivery to return or exchange any items. To be eligible for a return, your item must be unused, in the same condition that you received it, and in its original packaging.</p>
                        </section>

                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Easy Return Process</h2>
                            <ol class="list-decimal pl-5 space-y-2">
                                <li>Use our <a href="{{ route('track.order.form') }}" class="text-indigo-600 hover:text-indigo-500 underline font-medium">Order Tracking</a> page to locate your order.</li>
                                <li>Click on the "Request Refund" button next to the item you wish to return.</li>
                                <li>Select the reason for return and provide a short description.</li>
                                <li>Once approved, we will schedule a pickup within 2-3 business days.</li>
                            </ol>
                        </section>

                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Refunds</h2>
                            <p>Once we receive and inspect your return, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed, and a credit will automatically be applied to your original method of payment within 7-10 business days.</p>
                        </section>

                        <div class="mt-12 bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                            <h3 class="text-indigo-900 font-bold mb-2">Need immediate assistance?</h3>
                            <p class="text-indigo-700 text-sm">Contact our support team at <a href="mailto:returns@abcshop.com" class="font-bold underline">returns@abcshop.com</a> or call us at +1 (800) 123-4567.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>
