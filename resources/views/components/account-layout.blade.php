<x-shop-layout>
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Account</h1>
            
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
                <!-- Sidebar -->
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="{{ request()->routeIs('dashboard') ? 'bg-white text-accent shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium transition">
                            <svg class="{{ request()->routeIs('dashboard') ? 'text-accent' : 'text-gray-400 group-hover:text-gray-500' }} flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="truncate">Dashboard</span>
                        </a>

                        <a href="{{ route('orders.index') }}" 
                           class="{{ request()->routeIs('orders.*') ? 'bg-white text-accent shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium transition">
                            <svg class="{{ request()->routeIs('orders.*') ? 'text-accent' : 'text-gray-400 group-hover:text-gray-500' }} flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="truncate">My Orders</span>
                        </a>

                        <a href="{{ route('addresses.index') }}" 
                           class="{{ request()->routeIs('addresses.*') ? 'bg-white text-accent shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium transition">
                            <svg class="{{ request()->routeIs('addresses.*') ? 'text-accent' : 'text-gray-400 group-hover:text-gray-500' }} flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate">Address Book</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" 
                           class="{{ request()->routeIs('profile.edit') ? 'bg-white text-accent shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium transition">
                            <svg class="{{ request()->routeIs('profile.edit') ? 'text-accent' : 'text-gray-400 group-hover:text-gray-500' }} flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="truncate">Profile</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left text-gray-600 hover:bg-white hover:text-red-500 group rounded-md px-3 py-2 flex items-center text-sm font-medium transition">
                                <svg class="text-gray-400 group-hover:text-red-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="truncate">Logout</span>
                            </button>
                        </form>
                    </nav>
                </aside>

                <!-- Content -->
                <div class="lg:col-span-9">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>

