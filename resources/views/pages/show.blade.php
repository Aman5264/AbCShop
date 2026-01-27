@if($page->custom_css)
    @push('styles')
        <style>
            {!! $page->custom_css !!}
        </style>
    @endpush
@endif

<x-shop-layout>
    <x-slot name="title">{{ $page->meta_title ?? $page->title }}</x-slot>
    
    @if($page->meta_description)
        <x-slot name="meta_description">{{ $page->meta_description }}</x-slot>
    @endif

    <div class="bg-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">{{ $page->title }}</h1>
            
            <div class="prose prose-lg max-w-none text-gray-600">
                {!! $page->content !!}
            </div>

            @if($page->custom_html)
                <div class="mt-8">
                    {!! $page->custom_html !!}
                </div>
            @endif
        </div>
    </div>
</x-shop-layout>

