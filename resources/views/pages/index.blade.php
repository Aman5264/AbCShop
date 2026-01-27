<x-shop-layout>
    <x-slot name="title">Blog - ABCSHOP</x-slot>

    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Latest Updates
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    News and articles from ABCSHOP.
                </p>
            </div>

            <div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                @foreach($pages as $page)
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden transition hover:shadow-xl">
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <a href="{{ route('pages.show', $page->slug) }}" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900">
                                    {{ $page->title }}
                                </p>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                    {{ $page->meta_description ?? Str::limit(strip_tags($page->content), 150) }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $page->creator->name ?? 'Admin' }}
                                </p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <time datetime="{{ $page->published_at }}">
                                        {{ $page->published_at->format('M d, Y') }}
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $pages->links() }}
            </div>
        </div>
    </div>
</x-shop-layout>

