<x-shop-layout>
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm font-medium text-gray-500">
                <a href="{{ route('shop.index') }}" class="hover:text-primary transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>

            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start" x-data="{ qty: 1 }">
                <!-- Image Gallery -->
                <div class="flex flex-col" x-data="{ activeImage: '{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}', showVideo: false }">
                    <!-- Main Display -->
                    <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-xl overflow-hidden shadow-inner relative">
                        <template x-if="!showVideo">
                           <img :src="activeImage" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-center object-cover hover:scale-110 transition duration-700">
                        </template>
                        
                        @if($product->video_url)
                        <template x-if="showVideo">
                            <video class="w-full h-full object-cover" controls autoplay muted loop>
                                <source src="{{ Storage::url($product->video_url) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </template>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    <div class="mt-4 grid grid-cols-4 gap-4">
                        <!-- Main Image Thumb -->
                        <button @click="activeImage = '{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}'; showVideo = false" 
                                class="aspect-square rounded-lg border-2 overflow-hidden transition"
                                :class="activeImage === '{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}' && !showVideo ? 'border-accent' : 'border-transparent hover:border-gray-300'">
                            <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : Storage::url($product->image_url) }}" class="w-full h-full object-cover">
                        </button>

                        <!-- Gallery Photos -->
                        @if($product->images)
                            @foreach($product->images as $img)
                                <button @click="activeImage = '{{ Storage::url($img) }}'; showVideo = false" 
                                        class="aspect-square rounded-lg border-2 overflow-hidden transition"
                                        :class="activeImage === '{{ Storage::url($img) }}' && !showVideo ? 'border-accent' : 'border-transparent hover:border-gray-300'">
                                    <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        @endif

                        <!-- Video Thumb -->
                        @if($product->video_url)
                            <button @click="showVideo = true; activeImage = ''" 
                                    class="aspect-square rounded-lg border-2 overflow-hidden transition bg-black relative flex items-center justify-center text-white"
                                    :class="showVideo ? 'border-accent' : 'border-transparent hover:border-gray-300'">
                                <i class="fas fa-play text-xl"></i>
                                <span class="absolute bottom-1 left-0 w-full text-[8px] font-bold uppercase text-center bg-black/50 py-0.5">Video</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                    <div class="flex flex-col">
                        @if($product->is_on_sale && $product->sale_end_date)
                            <div class="mb-2">
                                <x-countdown-timer :expires="$product->sale_end_date" />
                            </div>
                        @endif
                        <h2 class="text-sm font-bold text-accent tracking-widest uppercase">{{ $product->brand ?? 'ABC PREMIUM' }}</h2>
                        <h1 class="text-4xl font-extrabold tracking-tight text-primary mt-2">{{ $product->name }}</h1>
                        
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center">
                                @if($product->is_on_sale)
                                    <p class="text-4xl text-red-600 font-bold">₹{{ number_format($product->sale_price, 2) }}</p>
                                    <p class="ml-4 text-xl text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</p>
                                    <span class="ml-3 bg-red-100 text-red-600 text-xs px-2 py-1 rounded font-bold uppercase tracking-wider">
                                        FLASH SALE
                                    </span>
                                @else
                                    <p class="text-3xl text-gray-900 font-bold">₹{{ number_format($product->price, 2) }}</p>
                                    @if($product->cost_price && $product->cost_price > $product->price)
                                        <p class="ml-4 text-xl text-gray-400 line-through">₹{{ number_format($product->cost_price, 2) }}</p>
                                        <span class="ml-3 bg-red-100 text-red-600 text-xs px-2 py-1 rounded font-bold uppercase tracking-wider">
                                            {{ round((($product->cost_price - $product->price) / $product->cost_price) * 100) }}% OFF
                                        </span>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-1">
                                <span class="text-green-600 font-bold text-sm">
                                    <i class="fas fa-check-circle mr-1"></i> In Stock
                                </span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-sm font-bold text-gray-900">Description</h3>
                            <div class="mt-3 text-base text-gray-600 leading-relaxed italic">
                                "{!! $product->description !!}"
                            </div>
                        </div>

                        <!-- Add to Cart Controls -->
                        <div class="mt-10 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <!-- Quantity -->
                            <div class="flex items-center justify-between mb-8">
                                <label class="text-sm font-bold text-gray-900 uppercase tracking-wider">Select Quantity</label>
                                <div class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <button @click="if(qty > 1) qty--" type="button" class="px-4 py-2 text-gray-500 hover:text-accent transition">-</button>
                                    <span class="w-12 text-center text-sm font-bold text-gray-900" x-text="qty"></span>
                                    <button @click="if(qty < 10) qty++" type="button" class="px-4 py-2 text-gray-500 hover:text-accent transition">+</button>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a :href="'{{ route('add.to.cart', $product->id) }}?quantity=' + qty" 
                                   class="flex-1 bg-primary text-white text-center py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg transform active:scale-95">
                                   Add to Cart
                                </a>
                                <a :href="'{{ route('add.to.cart', $product->id) }}?buy_now=1&quantity=' + qty" 
                                   class="flex-1 bg-accent text-white text-center py-4 rounded-xl font-bold hover:bg-yellow-500 transition shadow-lg transform active:scale-95">
                                   Buy Now
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
                                     }">
                                    <button @click="toggleWishlist()" type="button" class="h-full px-5 bg-gray-100 rounded-xl text-gray-500 hover:text-red-500 hover:bg-red-50 transition shadow-lg flex items-center justify-center" title="Add to Wishlist">
                                        <svg xmlns="http://www.w3.org/2000/svg" :fill="isInWishlist ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" :class="isInWishlist ? 'text-red-500' : ''">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Features -->
                        <div class="mt-8 grid grid-cols-3 gap-4">
                            <div class="text-center p-3 rounded-lg bg-white border border-gray-100">
                                <i class="fas fa-shipping-fast text-accent mb-2"></i>
                                <p class="text-[10px] font-bold text-gray-500 uppercase">Fast Delivery</p>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-white border border-gray-100">
                                <i class="fas fa-shield-alt text-accent mb-2"></i>
                                <p class="text-[10px] font-bold text-gray-500 uppercase">Secure Payment</p>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-white border border-gray-100">
                                <i class="fas fa-sync text-accent mb-2"></i>
                                <p class="text-[10px] font-bold text-gray-500 uppercase">Easy Returns</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="mt-20 border-t border-gray-100 pt-16">
                <h2 class="text-2xl font-black text-primary tracking-tight mb-10">Customer Reviews</h2>
                
                <div class="grid md:grid-cols-2 gap-16 items-start">
                    <!-- List Reviews -->
                    <div class="space-y-10">
                        @forelse($product->reviews as $review)
                            <div class="border-b border-gray-100 pb-8 last:border-0">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs">
                                        @for($i=1; $i<=5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">
                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 leading-relaxed text-sm">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-gray-50 rounded-xl">
                                <p class="text-gray-500 italic mb-2">No reviews yet.</p>
                                <p class="text-sm text-gray-400">Be the first to share your thoughts on this product!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Write Review -->
                    <div class="bg-gray-50 p-8 rounded-2xl sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Write a Review</h3>
                        
                        @auth
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Rating</label>
                                    <div class="flex gap-1" x-data="{ rating: 5, hoverRating: 0 }">
                                        @for($i=1; $i<=5; $i++)
                                            <label class="cursor-pointer" @mouseenter="hoverRating = {{ $i }}" @mouseleave="hoverRating = 0">
                                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" x-model="rating" {{ $i==5 ? 'checked' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                                                     class="w-8 h-8 transition-colors duration-150"
                                                     :class="(hoverRating >= {{ $i }} || (hoverRating === 0 && rating >= {{ $i }})) ? 'text-yellow-400' : 'text-gray-300'">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Comment</label>
                                    <textarea name="comment" rows="4" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:ring-accent focus:border-accent transition text-sm" placeholder="What did you like or dislike?" required></textarea>
                                </div>

                                <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">Submit Review</button>
                            </form>
                        @else
                            <div class="text-center py-6">
                                <p class="text-gray-600 mb-6 text-sm">Please login to write a review about this product.</p>
                                <a href="{{ route('login') }}" class="block w-full bg-white border border-gray-300 text-gray-900 py-3 rounded-xl font-bold hover:bg-gray-50 transition">Login / Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <h2 class="text-2xl font-black text-primary tracking-tight mb-8">Matching Style</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('shop.show', $related->id) }}" class="group">
                            <div class="aspect-[3/4] rounded-xl overflow-hidden bg-gray-100 mb-4">
                                <img src="{{ Str::startsWith($related->image_url, 'http') ? $related->image_url : Storage::url($related->image_url) }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $related->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">₹{{ number_format($related->price, 2) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-shop-layout>

