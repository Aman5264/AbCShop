<x-shop-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">FAQ / Help Center</h1>
                <p class="text-xl text-gray-600">Find answers to common questions about shipping, returns, and more.</p>
                
                <div class="mt-8 max-w-xl mx-auto">
                    <form action="{{ route('faq.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search for questions..." 
                            class="block w-full pl-10 pr-3 py-4 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 sm:text-lg transition duration-200 shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        @if($search)
                            <a href="{{ route('faq.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            @if($categories->isEmpty())
                <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No questions found</h3>
                    <p class="mt-1 text-sm text-gray-500">We couldn't find any questions matching your search.</p>
                    <div class="mt-6">
                        <a href="{{ route('faq.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            Clear search
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-12">
                    @foreach($categories as $category)
                        <div id="category-{{ $category->slug }}">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <span class="bg-orange-100 text-orange-600 p-2 rounded-lg mr-3">
                                    @if($category->slug == 'shipping')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    @elseif($category->slug == 'returns')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2z"></path></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                </span>
                                {{ $category->name }}
                            </h2>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100" x-data="{ active: null }">
                                @foreach($category->faqs as $faq)
                                    <div class="faq-item">
                                        <button @click="active = (active === {{ $faq->id }} ? null : {{ $faq->id }}); if(active === {{ $faq->id }}) fetch('{{ route('faq.increment', $faq->id) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})"
                                            class="w-full text-left px-6 py-5 focus:outline-none flex justify-between items-center group transition duration-150 ease-in-out hover:bg-gray-50">
                                            <span class="text-lg font-medium text-gray-900 group-hover:text-orange-600 transition-colors">{{ $faq->question }}</span>
                                            <svg class="ml-4 h-6 w-6 text-gray-500 transform transition-transform duration-200" :class="{'rotate-180': active === {{ $faq->id }}}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div x-show="active === {{ $faq->id }}" 
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            class="px-6 pb-6 text-gray-600 prose prose-orange max-w-none">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-shop-layout>
