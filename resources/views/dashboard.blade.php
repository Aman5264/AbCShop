<x-account-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Dashboard</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Overview of your account activity.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <!-- Total Orders - Clickable -->
                <a href="{{ route('orders.index') }}" class="bg-gray-50 overflow-hidden rounded-lg px-4 py-5 sm:p-6 border border-gray-100 hover:bg-gray-100 hover:shadow-md transition cursor-pointer">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ auth()->user()->orders()->count() }}</dd>
                    <p class="mt-2 text-xs text-indigo-600 flex items-center">
                        View all
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </p>
                </a>
                
                
                <!-- Pending Orders - Clickable -->
                <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="bg-yellow-50 overflow-hidden rounded-lg px-4 py-5 sm:p-6 border border-yellow-200 hover:bg-yellow-100 hover:shadow-md transition cursor-pointer">
                    <dt class="text-sm font-medium text-gray-600 truncate">Pending Orders</dt>
                    <dd class="mt-1 text-3xl font-semibold text-accent">{{ auth()->user()->orders()->where('status', 'pending')->count() }}</dd>
                    <p class="mt-2 text-xs text-yellow-700 flex items-center">
                        Track pending
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </p>
                </a>
            </div>
            
            <div class="mt-8">
                <h4 class="text-base font-medium text-gray-900 mb-4">Recent Activity</h4>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Welcome back, {{ auth()->user()->name }}! Check your latest order status in the "My Orders" tab.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-account-layout>

