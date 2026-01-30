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
        
        <div class="flex overflow-x-auto gap-4 pb-8 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide snap-x snap-mandatory">
            @forelse($featuredProducts as $product)
                <div class="group relative flex flex-col flex-none w-[280px] sm:w-[320px] snap-center">
                    <!-- Image Container -->
                    <div class="aspect-[3/4] w-full overflow-hidden rounded-2xl bg-gray-100 relative mb-4">
                        <!-- Bestseller Badge -->
                        <div class="absolute top-3 left-3 z-10">
                            <span class="bg-black text-white text-[10px] font-bold px-2 py-1 rounded-sm tracking-wider uppercase">Bestseller</span>
                        </div>

                        <a href="{{ route('shop.show', $product->id) }}">
                            <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover object-center group-hover:scale-105 transition duration-500 ease-in-out"
                                 loading="lazy">
                        </a>
                        
                        <!-- Quick Add Button -->
                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition duration-300 translate-y-2 group-hover:translate-y-0">
                            <a href="{{ route('add.to.cart', $product->id) }}" class="bg-white text-black p-3 rounded-full shadow-xl hover:bg-black hover:text-white transition transform hover:scale-110 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex flex-col px-1">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">{{ $product->brand ?? 'ABC PREMIUM' }}</p>
                        <h3 class="text-base font-medium text-gray-900 mb-1 truncate">
                            <a href="{{ route('shop.show', $product->id) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                         <p class="text-sm text-gray-500 mb-2 truncate">{{ $product->description ?? 'Premium quality comfort' }}</p>
                        
                        <div class="mt-auto flex items-center gap-2">
                            @if($product->is_on_sale)
                                <p class="text-lg font-bold text-black">₹{{ number_format($product->sale_price, 2) }}</p>
                                <p class="text-sm text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</p>
                            @else
                                <p class="text-lg font-bold text-black">₹{{ number_format($product->price, 2) }}</p>
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
