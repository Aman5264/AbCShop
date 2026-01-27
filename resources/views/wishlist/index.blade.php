<x-shop-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Wishlist <span class="text-gray-500 text-lg font-normal">({{ $wishlistItems->count() }} Items)</span></h1>

            @if($wishlistItems->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $item)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group">
                            <!-- Image -->
                            <div class="relative h-64 bg-gray-200 overflow-hidden">
                                <a href="{{ route('shop.show', $item->product_id) }}">
                                    <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : Storage::url($item->product->image_url) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="h-full w-full object-cover object-center group-hover:scale-105 transition duration-300">
                                </a>
                                
                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.toggle', $item->product_id) }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    <button type="submit" class="bg-white/80 backdrop-blur rounded-full p-2 text-red-500 hover:bg-white transition shadow-sm" title="Remove from Wishlist">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                          <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="text-sm font-medium text-gray-900 truncate">
                                    <a href="{{ route('shop.show', $item->product_id) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $item->product->brand ?? 'Brand' }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="text-lg font-bold text-gray-900">₹{{ number_format($item->product->price, 2) }}</p>
                                    
                                    @if($item->product->stock > 0)
                                        <a href="{{ route('add.to.cart', $item->product_id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                            Add to Cart
                                        </a>
                                    @else
                                        <span class="text-sm font-medium text-red-500">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center h-96 flex flex-col items-center justify-center">
                    <div class="text-gray-200 mb-6">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-24 h-24">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                         </svg>
                    </div>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">Your Wishlist is Empty</h2>
                    <p class="text-gray-500 mb-8 max-w-sm">Save items you love and buy them later.</p>
                    <a href="{{ route('shop.index') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-full font-medium hover:bg-indigo-700 transition shadow-lg">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-shop-layout>

