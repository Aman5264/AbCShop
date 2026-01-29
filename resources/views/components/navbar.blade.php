<nav x-data="{ open: false, searchOpen: false }" class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Left: Logo & Mobile Menu -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('shop.index') }}" class="flex items-center gap-2">
                        <span class="text-xl sm:text-2xl font-bold tracking-tight text-primary">ABC<span class="text-accent">SHOP</span></span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('shop.index') ? 'border-accent text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        Home
                    </a>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('blog.*') ? 'border-accent text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        Blog
                    </a>
                    <a href="{{ route('faq.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('faq.*') ? 'border-accent text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        FAQ
                    </a>
                    
                    @foreach($navPages as $page)
                    <a href="/{{ $page->slug }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is($page->slug) ? 'border-accent text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ $page->title }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Center: Search Bar (Desktop) -->
            <div class="hidden sm:flex flex-1 max-w-lg mx-8 relative" 
                 x-data="{ 
                    query: '', 
                    suggestions: [],
                    open: false,
                    async fetchSuggestions() {
                        if (this.query.length < 2) {
                            this.suggestions = [];
                            this.open = false;
                            return;
                        }
                        try {
                            let response = await fetch(`/api/autocomplete?query=${this.query}`);
                            this.suggestions = await response.json();
                            this.open = this.suggestions.length > 0;
                        } catch (e) {
                            console.error(e);
                        }
                    }
                 }"
                 @click.away="open = false">
                <div class="relative w-full">
                    <input type="text" 
                           x-model="query"
                           @input.debounce.300ms="fetchSuggestions()"
                           @focus="open = suggestions.length > 0"
                           placeholder="Search for products, brands and more" 
                           class="w-full bg-gray-50 border-gray-300 focus:border-accent focus:ring-accent rounded-full py-2 pl-4 pr-10 text-sm transition-shadow">
                    <button class="absolute right-0 top-0 h-full px-4 text-gray-400 hover:text-accent transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    
                    <!-- Autocomplete Dropdown -->
                    <div x-show="open" 
                         x-transition 
                         class="absolute z-50 w-full bg-white mt-1 rounded-md shadow-lg border border-gray-100 py-1"
                         style="display: none;">
                        <template x-for="suggestion in suggestions" :key="suggestion">
                            <a :href="`/shop?search=${suggestion}`" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center justify-between">
                                <span x-text="suggestion"></span>
                                <svg class="w-4 h-4 text-gray-400 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right: Icons -->
            <div class="flex items-center gap-4 sm:ml-6">
                <!-- Search (Mobile) -->
                <button @click="searchOpen = !searchOpen" class="sm:hidden p-2 text-gray-500 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>

                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}" class="hidden sm:flex flex-col items-center group">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 group-hover:text-primary transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="group relative flex flex-col items-center">
                    <div class="relative py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 group-hover:text-primary transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 -mt-1 -mr-2 inline-flex items-center justify-center h-5 w-5 rounded-full bg-accent text-[10px] font-bold text-white border-2 border-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>
                </a>

                <!-- Account -->
                @auth
                    <div class="hidden sm:flex relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
                           {{ Auth::user()->name }}
                           <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 top-full mt-2 w-48 bg-white shadow-lg rounded-md py-1 border border-gray-100 z-50" style="display: none;">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-900 hover:text-accent">Login</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-4 pb-3 space-y-1 px-4">
            <!-- Mobile Search -->
            <div class="mb-4" x-data="{ query: '' }">
                <form action="{{ route('shop.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search..." class="w-full bg-gray-50 border-gray-300 rounded-lg py-2 pl-4 pr-10 text-sm focus:ring-accent focus:border-accent">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <a href="{{ route('shop.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('shop.index') ? 'text-accent bg-gray-50 border-l-4 border-accent' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">Home</a>
            <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('blog.*') ? 'text-accent bg-gray-50 border-l-4 border-accent' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">Blog</a>
            <a href="{{ route('faq.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('faq.*') ? 'text-accent bg-gray-50 border-l-4 border-accent' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">FAQ</a>
            
            @foreach($navPages as $page)
                <a href="/{{ $page->slug }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is($page->slug) ? 'text-accent bg-gray-50 border-l-4 border-accent' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                    {{ $page->title }}
                </a>
            @endforeach
        </div>
        <div class="pt-4 pb-4 border-t border-gray-200">
             @auth
                <div class="px-4 flex items-center gap-3">
                     <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block w-full text-left px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Log Out</button>
                    </form>
                </div>
             @else
                 <div class="px-4">
                     <a href="{{ route('login') }}" class="block w-full text-center bg-primary text-white py-2 rounded-md">Login / Signup</a>
                 </div>
             @endauth
        </div>
    </div>
</nav>

