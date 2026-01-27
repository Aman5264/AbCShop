<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Create New Coupon</h2>
                        <div>
                            <a href="/admin" class="text-sm text-indigo-600 hover:text-indigo-900 mr-4">Back to Admin Panel</a>
                            <a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-gray-900">← Back to List</a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Coupon Code *</label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="e.g., SAVE20">
                            <p class="mt-1 text-sm text-gray-500">Must be unique. Customers will enter this code.</p>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Discount Type *</label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                                <option value="percent" {{ old('type') === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                            </select>
                        </div>

                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700">Discount Value *</label>
                            <input type="number" name="value" id="value" value="{{ old('value') }}" step="0.01" min="0" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="10">
                            <p class="mt-1 text-sm text-gray-500">For fixed: rupee amount. For percent: percentage (0-100)</p>
                        </div>

                        <div>
                            <label for="min_order_amount" class="block text-sm font-medium text-gray-700">Minimum Order Amount</label>
                            <input type="number" name="min_order_amount" id="min_order_amount" value="{{ old('min_order_amount') }}" step="0.01" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="0.00">
                            <p class="mt-1 text-sm text-gray-500">Optional. Leave blank for no minimum.</p>
                        </div>

                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Optional. Leave blank for no expiry.</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Active (enable this coupon)</label>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.coupons.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Create Coupon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

