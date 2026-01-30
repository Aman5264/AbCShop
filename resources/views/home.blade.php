<x-shop-layout>
    <!-- Dynamic Banners Section -->
    @if($banners->isNotEmpty())
    <div x-data="{ activeSlide: 0, slides: {{ $banners->count() }}, interval: null }" 
         x-init="interval = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 5000)"
         class="relative bg-gray-900 aspect-[4/3] sm:aspect-[16/9] md:aspect-[21/9] overflow-hidden group">
        
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
    @else
    <!-- Fallback Static Hero -->
    <div class="relative bg-gray-900 aspect-[4/3] sm:aspect-[16/9] md:aspect-[21/9] overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                 alt="Hero" class="w-full h-full object-cover opacity-60">
        </div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight mb-4 sm:mb-6 leading-tight">Featured Collections</h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 font-light text-gray-100">Handpicked premium products just for you</p>
                <a href="{{ route('shop.index') }}" class="inline-block bg-accent hover:bg-yellow-500 text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 shadow-xl">
                    View All Products
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
                <a href="{{ route('shop.category', $category->slug) }}" class="flex flex-col items-center min-w-[100px] group cursor-pointer text-center">
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

    <!-- Featured Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-black text-primary tracking-tight">Featured Products</h2>
            <a href="{{ route('shop.index') }}" class="text-accent font-bold hover:text-yellow-600 transition flex items-center gap-1">
                View All <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredProducts as $product)
                <div class="group relative flex flex-col h-full bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Image -->
                    <div class="aspect-[4/5] w-full overflow-hidden bg-gray-200 relative">
                        <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}" 
                             alt="{{ $product->name }}" 
                             class="h-full w-full object-cover object-center group-hover:scale-110 transition duration-700 ease-in-out"
                             loading="lazy">
                        
                        <!-- Quick Add Button -->
                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition duration-300 translate-y-2 group-hover:translate-y-0">
                            <a href="{{ route('add.to.cart', $product->id) }}" class="bg-white text-primary p-3 rounded-full shadow-lg hover:bg-accent hover:text-white transition transform hover:scale-105 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex flex-col flex-1">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">{{ $product->brand ?? 'ABC PREMIUM' }}</p>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-accent transition-colors mb-2 line-clamp-2">
                            <a href="{{ route('shop.show', $product->id) }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <div class="mt-auto flex items-end justify-between">
                            <div class="flex flex-col">
                                @if($product->is_on_sale)
                                    <p class="text-xl font-bold text-red-600">₹{{ number_format($product->sale_price, 2) }}</p>
                                    <p class="text-sm text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</p>
                                @else
                                    <p class="text-xl font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</p>
                                @endif
                            </div>
                            <!-- Rating Placeholder -->
                            <div class="flex text-yellow-400 text-xs">
                                @for($i=0; $i<5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-gray-50 rounded-3xl">
                    <p class="text-gray-500 text-lg mb-4">No featured products found.</p>
                    <a href="{{ route('shop.index') }}" class="text-accent font-bold hover:underline">Browse all products</a>
                </div>
            @endforelse
        </div>
        
        <div class="mt-16 text-center">
             <a href="{{ route('shop.index') }}" class="inline-block bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-bold py-4 px-10 rounded-full transition duration-300 transform hover:scale-105 shadow-lg">
                View Entire Collection
            </a>
        </div>
    </div>
</x-shop-layout>
