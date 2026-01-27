<footer class="bg-primary text-white pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Brand -->
            <div>
                <span class="text-2xl font-bold tracking-tight text-white">ABC<span class="text-accent">SHOP</span></span>
                <p class="mt-4 text-gray-400 text-sm">Experience the premium shopping destination for the modern lifestyle. Quality meets luxury.</p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-lg mb-4">Shop</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('blog.index') }}" class="hover:text-accent transition flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg> Blog / News</a></li>
                    <li><a href="#" class="hover:text-accent transition">Men</a></li>
                    <li><a href="#" class="hover:text-accent transition">Women</a></li>
                    <li><a href="#" class="hover:text-accent transition">Kids</a></li>
                    <li><a href="#" class="hover:text-accent transition">New Arrivals</a></li>
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h4 class="font-bold text-lg mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('faq.index') }}" class="hover:text-accent transition">FAQ / Help Center</a></li>
                    <li><a href="{{ route('track.order.form') }}" class="hover:text-accent transition">Track Order</a></li>
                    <li><a href="#" class="hover:text-accent transition">Returns & Exchanges</a></li>
                    <li><a href="#" class="hover:text-accent transition">Customer Service</a></li>
                    <li><a href="#" class="hover:text-accent transition">Terms & Conditions</a></li>
                </ul>
            </div>
            
            <!-- Newsletter -->
            <div>
                <h4 class="font-bold text-lg mb-4">Stay in the Loop</h4>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email" required class="bg-gray-800 border-none rounded-l-md px-4 py-2 w-full focus:ring-1 focus:ring-accent text-sm text-white">
                    <button type="submit" class="bg-accent text-white px-4 py-2 rounded-r-md font-bold hover:bg-yellow-500 transition">Join</button>
                </form>
                @if(session('success'))
                    <p class="text-green-400 text-xs mt-2">{{ session('success') }}</p>
                @endif
                @error('email')
                    <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} ABCSHOP. All rights reserved.</p>
            <div class="flex gap-4">
                <span class="text-gray-500 text-sm">Follow us</span>
                <!-- Social Icons Placeholder -->
            </div>
        </div>
    </div>
</footer>

