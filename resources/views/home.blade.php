<x-shop-layout>
    <!-- Dynamic Banners Section -->
    @if($banners->isNotEmpty())
    <div x-data="{ activeSlide: 0, slides: {{ $banners->count() }}, interval: null }" 
         x-init="interval = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 5000)"
         class="relative bg-gray-900 overflow-hidden group">
        
        <!-- Slides -->
        <div class="grid grid-cols-1">
            @foreach($banners as $index => $banner)
            <div x-show="activeSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform scale-105"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="col-start-1 row-start-1 w-full h-auto"
                 style="display: none;">
                
                <!-- Desktop Image -->
                <img src="{{ Str::startsWith($banner->image_url, 'http') ? $banner->image_url : Storage::url($banner->image_url) }}" 
                     alt="{{ $banner->title }}" 
                     class="hidden md:block w-full h-auto object-cover">
                
                <!-- Mobile Image -->
                <img src="{{ $banner->mobile_image_url ? (Str::startsWith($banner->mobile_image_url, 'http') ? $banner->mobile_image_url : Storage::url($banner->mobile_image_url)) : (Str::startsWith($banner->image_url, 'http') ? $banner->image_url : Storage::url($banner->image_url)) }}" 
                     alt="{{ $banner->title }}" 
                     class="block md:hidden w-full h-auto object-cover">
                
                <!-- Overlay & Content -->
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none">
                    <div class="text-center text-white px-4 max-w-4xl pointer-events-auto">
                        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight mb-4 sm:mb-6 leading-tight drop-shadow-md">
                            {{ $banner->title }}
                        </h1>
                        @if($banner->description)
                        <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 font-light text-gray-100 drop-shadow-sm line-clamp-2">
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
        </div>

        <!-- Navigation Arrows (Hidden on mobile) -->
        <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" 
                class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full backdrop-blur-sm transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" 
                class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full backdrop-blur-sm transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2 z-10">
            @foreach($banners as $index => $banner)
            <button @click="activeSlide = {{ $index }}" 
                    :class="activeSlide === {{ $index }} ? 'bg-accent w-8' : 'bg-white/50 w-2 hover:bg-white'"
                    class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
    </div>
    @else
    <!-- Fallback Static Hero -->
    <div class="relative bg-gray-900 aspect-[3/4] sm:aspect-[16/9] md:aspect-[21/9] overflow-hidden">
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
            <div class="flex gap-2 overflow-x-auto pb-4 scrollbar-hide">
                <a href="{{ route('shop.index') }}" class="flex flex-col items-center min-w-[70px] group cursor-pointer text-center">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-full bg-gray-100 flex items-center justify-center mb-3 group-hover:ring-2 ring-accent transition">
                        <span class="text-gray-500 font-medium">All</span>
                    </div>
                    <span class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-accent">View All</span>
                </a>
                @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="flex flex-col items-center min-w-[70px] group cursor-pointer text-center">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-full bg-gray-100 overflow-hidden mb-3 group-hover:ring-2 ring-accent transition">
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
        
        <div class="flex overflow-x-auto gap-4 pb-8 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide snap-x snap-mandatory">
            @forelse($featuredProducts as $product)
                <div class="group relative flex flex-col flex-none w-[200px] sm:w-[320px] snap-center bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    
                    <!-- Bestseller Badge (Logic or Static) -->
                    <div class="absolute top-3 left-0 z-20">
                        <span class="bg-black/80 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-r-sm tracking-wider uppercase">Bestseller</span>
                    </div>

                    <!-- Image Container -->
                    <div class="aspect-[3/4] w-full overflow-hidden bg-gray-100 relative">
                        <a href="{{ route('shop.show', $product->id) }}">
                            <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover object-center group-hover:scale-110 transition duration-700 ease-in-out"
                                 loading="lazy">
                        </a>
                        
                         <!-- Bottom Left Icon (Similar/Copy) -->
                        <button class="absolute bottom-3 left-3 bg-white/90 backdrop-blur text-gray-700 p-2 rounded-lg shadow-sm hover:bg-white transition opacity-90 hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5" />
                            </svg>
                        </button>

                        <!-- Bottom Right Wishlist Pill -->
                        <button class="absolute bottom-3 right-3 flex items-center gap-1 bg-white/90 backdrop-blur text-gray-700 px-2 py-1.5 rounded-full shadow-sm hover:bg-white transition opacity-90 hover:opacity-100">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <span class="text-xs font-bold">120</span>
                        </button>
                    </div>

                    <!-- Details -->
                    <div class="p-4 flex flex-col flex-1">
                         <!-- Brand -->
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">{{ $product->brand ?? 'ABC BRAND' }}</h4>

                        <h3 class="text-sm font-medium text-gray-900 mb-1 leading-tight line-clamp-2">
                            <a href="{{ route('shop.show', $product->id) }}" class="hover:text-primary transition-colors">
                                {{ $product->name }}
                            </a>
                        </h3>

                         <!-- Stars -->
                        <div class="flex items-center gap-0.5 mb-2">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-3 h-3 text-yellow-500 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                            <span class="text-xs text-gray-400 ml-1">(12)</span>
                        </div>
                        
                        <div class="mt-auto">
                            <div class="flex items-center gap-2 mb-1">
                               @if($product->is_on_sale)
                                    <span class="text-base font-bold text-gray-900">₹{{ number_format($product->sale_price, 0) }}</span>
                                    <span class="text-xs text-gray-400 line-through">₹{{ number_format($product->price, 0) }}</span>
                                    <span class="text-xs font-bold text-green-600">
                                        {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% off
                                    </span>
                                @else
                                    <span class="text-base font-bold text-gray-900">₹{{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                            @if($product->is_on_sale)
                                <p class="text-[10px] font-medium text-green-700">Offer Price ₹{{ number_format($product->sale_price, 0) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full py-20 text-center bg-gray-50 rounded-3xl mx-auto">
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
