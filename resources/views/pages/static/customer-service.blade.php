<x-shop-layout>
    <x-slot name="title">Customer Service - ABCSHOP</x-slot>
    
    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-12">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8 border-b border-gray-100 pb-4">Customer Service</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-1">Email Support</h3>
                            <p class="text-gray-600 text-sm">Response within 24 hours</p>
                            <a href="mailto:support@abcshop.com" class="text-blue-600 font-bold text-sm mt-3 inline-block">support@abcshop.com</a>
                        </div>
                        <div class="bg-green-50 p-6 rounded-xl border border-green-100">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-1">Phone Support</h3>
                            <p class="text-gray-600 text-sm">Mon-Fri, 9am - 6pm EST</p>
                            <a href="tel:+18001234567" class="text-green-600 font-bold text-sm mt-3 inline-block">+1 (800) 123-4567</a>
                        </div>
                    </div>

                    <div class="prose prose-blue max-w-none text-gray-600 space-y-6">
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Frequently Asked Questions</h2>
                            <p>Before reaching out, you might find your answer in our <a href="{{ route('faq.index') }}" class="text-blue-600 hover:text-blue-500 underline font-medium">FAQ Center</a> which covers topics like shipping, sizing, and order modifications.</p>
                        </section>

                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Order Issues</h2>
                            <p>If you're having trouble with an existing order, please have your Order ID ready. You can find this in your confirmation email or by logging into your <a href="{{ route('track.order.form') }}" class="text-blue-600 hover:text-blue-500 underline font-medium">Account Dashboard</a>.</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>
