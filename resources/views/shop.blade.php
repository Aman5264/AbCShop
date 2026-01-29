<x-shop-layout>
    <!-- Hero Section (Show only on Home) -->
    <!-- Dynamic Banners Section -->
    @if($banners->isNotEmpty())
    <div x-data="{ activeSlide: 0, slides: {{ $banners->count() }}, interval: null }" 
         x-init="interval = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 5000)"
         class="relative bg-gray-900 h-[400px] md:h-[500px] overflow-hidden group">
        
        <!-- Slides -->
        @foreach($banners as $index => $banner)
        <div x-show="activeSlide === {{ $index }}"
             x-transition:enter="transition transform duration-700 ease-out"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition transform duration-700 ease-in"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-0 w-full h-full">
            
            <img src="{{ Str::startsWith($banner->image_url, 'http') ? $banner->image_url : Storage::url($banner->image_url) }}" 
                 alt="{{ $banner->title }}" 
                 class="w-full h-full object-cover">
            
            <!-- Overlay & Content -->
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <div class="text-center text-white px-4 max-w-4xl">
                    <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight mb-4 sm:mb-6 leading-tight drop-shadow-md">
                        {{ $banner->title }}
                    </h1>
                    @if($banner->description)
                    <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 font-light text-gray-100 drop-shadow-sm">
                        {{ $banner->description }}
                    </p>
                    @endif
                    @if($banner->link)
                    <a href="{{ $banner->link }}" class="inline-block bg-accent hover:bg-yellow-500 text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 shadow-xl">
                        Shop Collection
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <!-- Navigation Arrows (Hidden on mobile) -->
        <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" 
                class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full backdrop-blur-sm transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" 
                class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full backdrop-blur-sm transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2">
            @foreach($banners as $index => $banner)
            <button @click="activeSlide = {{ $index }}" 
                    :class="activeSlide === {{ $index }} ? 'bg-accent w-8' : 'bg-white/50 w-2 hover:bg-white'"
                    class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
    </div>
    @elseif(!request()->has('category') && !request()->has('search'))
    <!-- Fallback Static Hero -->
    <div class="relative bg-gray-900 h-[500px] overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                 alt="Hero" class="w-full h-full object-cover opacity-60">
        </div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight mb-4 sm:mb-6 leading-tight">New Season Arrivals</h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 font-light text-gray-100">Elevate your style with our premium collection</p>
                <a href="#products" class="inline-block bg-accent hover:bg-yellow-500 text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 shadow-xl">
                    Shop Collection
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Categories Rail -->
    <div class="bg-white py-12 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-primary mb-8">Shop by Category</h2>
            <div class="flex gap-8 overflow-x-auto pb-4 scrollbar-hide">
                <a href="{{ route('shop.index') }}" class="flex flex-col items-center min-w-[100px] group cursor-pointer text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-3 group-hover:ring-2 ring-accent transition">
                        <span class="text-gray-500 font-medium">All</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-accent">View All</span>
                </a>
                @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="flex flex-col items-center min-w-[100px] group cursor-pointer text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 overflow-hidden mb-3 group-hover:ring-2 ring-accent transition">
                        @if($category->image)
                             <img src="{{ Str::startsWith($category->image, 'http') ? $category->image : Storage::url($category->image) }}" class="w-full h-full object-cover">
                        @else
                             <!-- Placeholder Icon -->
                             <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                             </div>
                        @endif
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-accent truncate w-full">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content (PLP) -->
    <div id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Filters Sidebar (Desktop) -->
            <div class="hidden md:block w-1/4">
                <div class="sticky top-24 space-y-8">
                    <!-- Filter: Categories -->
                    <div>
                        <h3 class="font-bold text-gray-900 mb-4">Categories</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>
                                <a href="{{ route('shop.index') }}" class="{{ !request('category') ? 'text-accent font-bold' : 'hover:text-gray-900' }}">All Products</a>
                            </li>
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="{{ request('category') == $cat->slug ? 'text-accent font-bold' : 'hover:text-gray-900' }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Filter: Price (Placeholder) -->
                    <div>
                        <h3 class="font-bold text-gray-900 mb-4">Price Range</h3>
                        <div class="flex items-center gap-2">
                             <input type="number" placeholder="Min" class="w-20 rounded border-gray-300 text-sm">
                             <span class="text-gray-400">-</span>
                             <input type="number" placeholder="Max" class="w-20 rounded border-gray-300 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-primary">
                        @if(request('category'))
                            {{ $categories->where('slug', request('category'))->first()->name ?? 'Category' }}
                        @elseif(request('search'))
                            Results for "{{ request('search') }}"
                        @else
                            Trending Now
                        @endif
                    </h2>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select class="text-sm border-none bg-transparent font-medium text-gray-900 focus:ring-0 cursor-pointer">
                            <option>Popularity</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @forelse($products as $product)
                        <div class="group relative flex flex-col h-full bg-white border border-gray-100 rounded-lg hover:shadow-md transition-shadow">
                            <!-- Image -->
                            <div class="aspect-[4/5] w-full overflow-hidden rounded-t-lg bg-gray-200 relative">
                                <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-full w-full object-cover object-center group-hover:scale-105 transition duration-500 ease-in-out"
                                     loading="lazy">
                                
                                <!-- Quick Actions Overlay (Desktop) -->
                                <div class="hidden lg:flex absolute bottom-4 left-0 right-0 justify-center opacity-0 group-hover:opacity-100 transition duration-300 gap-2">
                                     <a href="{{ route('add.to.cart', $product->id) }}" class="bg-white text-primary p-3 rounded-full shadow-lg hover:bg-accent hover:text-white transition transform hover:-translate-y-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                     </a>
                                     <div x-data="{ 
                                            isInWishlist: {{ auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'true' : 'false' }},
                                            async toggleWishlist() {
                                                try {
                                                    let response = await fetch('{{ route('wishlist.toggle', $product->id) }}', {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'Accept': 'application/json',
                                                            'X-Requested-With': 'XMLHttpRequest'
                                                        }
                                                    });
                                                    if (response.status === 401) {
                                                        window.location.href = '{{ route('login') }}';
                                                        return;
                                                    }
                                                    let data = await response.json();
                                                    this.isInWishlist = data.status === 'added';
                                                } catch (e) {
                                                    console.error(e);
                                                }
                                            }
                                         }" class="relative z-20">
                                         <button @click.stop="toggleWishlist()" type="button" class="bg-white p-3 rounded-full shadow-lg hover:bg-red-50 transition transform hover:-translate-y-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" :fill="isInWishlist ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" :class="isInWishlist ? 'text-red-500' : 'text-primary'">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                         </button>
                                     </div>
                                </div>
                                
                                <!-- Mobile Quick Add Button -->
                                <a href="{{ route('add.to.cart', $product->id) }}" class="lg:hidden absolute bottom-2 right-2 bg-white/90 p-2 rounded-full shadow-sm text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Details -->
                            <div class="p-4 flex flex-col flex-1 justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">{{ $product->brand ?? 'Generic' }}</p>
                                    <h3 class="text-sm font-medium text-gray-900 group-hover:text-accent transition-colors line-clamp-2">
                                        <a href="{{ route('shop.show', $product->id) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                </div>
                                <div class="mt-2 flex flex-col">
                                    @if($product->is_on_sale)
                                        <div class="flex items-center gap-2">
                                            <p class="text-base font-bold text-red-600">₹{{ number_format($product->sale_price, 2) }}</p>
                                            <p class="text-xs text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</p>
                                        </div>
                                    @else
                                        <p class="text-base font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center justify-end">
                                    @if($product->stock <= 5)
                                        <p class="text-[10px] text-red-500 font-medium">Only {{ $product->stock }} left</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500">
                            No products found.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                     {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>
