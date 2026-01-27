<x-shop-layout>
    <div class="bg-white py-12 relative overflow-hidden">
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
            <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
                <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                </svg>
            </div>
        </div>
        
        <div class="relative px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
            <div class="text-lg max-w-prose mx-auto">
                <h1>
                    <span class="block text-base text-center text-indigo-600 font-semibold tracking-wide uppercase">{{ $post->category->name ?? 'News' }}</span>
                    <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $post->title }}</span>
                </h1>
                <div class="mt-4 flex items-center justify-center text-gray-500">
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                    <span class="mx-2">&bull;</span>
                    <span>By {{ $post->author->name }}</span>
                </div>
                @if($post->image)
                    <figure class="mt-8">
                         <img class="w-full rounded-lg" src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" width="1310" height="873">
                    </figure>
                @endif
            </div>
            
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
                {!! $post->content !!}
            </div>
            
            <!-- Tags -->
            @if($post->tags->count() > 0)
                <div class="mt-8 border-t border-gray-200 pt-8 max-w-prose mx-auto">
                    <h3 class="text-sm font-medium text-gray-500">Tags:</h3>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comments Section -->
            <div class="mt-12 bg-gray-50 rounded-xl p-6 md:p-8 max-w-prose mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Comments ({{ $post->comments->count() }})</h3>
                
                @auth
                    <form action="{{ route('blog.comment', $post->slug) }}" method="POST" class="mb-8">
                        @csrf
                        <div>
                            <label for="content" class="sr-only">Your Comment</label>
                            <textarea id="content" name="content" rows="3" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" placeholder="Share your thoughts..."></textarea>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Post Comment
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Please <a href="{{ route('login') }}" class="font-medium underline text-blue-700 hover:text-blue-600">log in</a> to leave a comment.
                                </p>
                            </div>
                        </div>
                    </div>
                @endauth
                
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($post->comments as $comment)
                        <li class="py-6">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                     <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                         {{ substr($comment->user->name, 0, 1) }}
                                     </div>
                                </div>
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900">{{ $comment->user->name }}</a>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <div class="mt-2 text-sm space-x-2">
                                        <span class="text-gray-500 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-500">No comments yet. Be the first to start the conversation!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-shop-layout>
