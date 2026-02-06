<x-app-layout>
    <div class="py-24 max-w-2xl mx-auto px-6">
        <!-- Back to Feed Button -->
        <div class="mb-6">
            <a href="{{ route('feed') }}" 
               onclick="restoreScrollPosition()"
               class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Back to Feed
            </a>
        </div>

        <!-- Post Detail -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-6">
            <!-- Header -->
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('profile.show', $post->user) }}">
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->full_name }}" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                </a>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="{{ route('profile.show', $post->user) }}" class="font-bold text-slate-900 hover:text-blue-600 transition">
                                {{ $post->user->full_name }}
                            </a>
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <span>{{ $post->user->profile->pseudo ? '@'.$post->user->profile->pseudo : '' }}</span>
                                <span>•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            @if($post->content)
                <p class="text-slate-800 mb-4 whitespace-pre-wrap leading-relaxed">{{ $post->content }}</p>
            @endif

            <!-- Images -->
            @if($post->images->isNotEmpty())
                <div class="rounded-2xl overflow-hidden mb-4 border border-slate-100 grid {{ $post->images->count() > 1 ? 'grid-cols-2' : 'grid-cols-1' }} gap-0.5">
                     @foreach($post->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Post Image" class="w-full h-full object-cover min-h-[200px] max-h-[500px]">
                     @endforeach
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
                <div 
                    x-data="{ 
                        liked: {{ $post->isLikedBy(Auth::user()) ? 'true' : 'false' }},
                        count: {{ $post->likes_count ?? 0 }}
                    }"
                >
                    <button 
                        @click="toggleLike({{ $post->id }}, $el)"
                        class="flex items-center gap-2 transition group"
                        :class="liked ? 'text-red-500' : 'text-slate-500 hover:text-red-500'"
                    >
                        <div class="p-2 rounded-full transition" :class="liked ? 'bg-red-50' : 'group-hover:bg-red-50'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-sm" x-text="count + ' Likes'"></span>
                    </button>
                </div>

                <div class="flex items-center gap-2 text-slate-500">
                    <div class="p-2 rounded-full bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                     <span class="font-medium text-sm">{{ $post->comments_count }} Comments</span>
                </div>
            </div>
        </div>

        <!-- Add Comment Form -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-6">
            <h3 class="font-bold text-slate-900 mb-4">Add a Comment</h3>
            <div class="flex gap-3">
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->full_name }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1">
                    <form action="{{ route('comment.create') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="body"
                                placeholder="Write a comment..." 
                                class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-100 placeholder:text-slate-400"
                                required
                            >
                            <button type="submit" class="absolute right-2 top-2 p-1.5 text-slate-400 hover:text-blue-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Comments List -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-900 mb-4">Comments</h3>
            <div class="space-y-4">
                @forelse($post->comments as $comment)
                    <div class="flex gap-3">
                        <a href="{{ route('profile.show', $comment->user) }}">
                            <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->full_name }}" class="w-10 h-10 rounded-full object-cover hover:opacity-80 transition">
                        </a>
                        <div class="flex-1">
                            <div class="bg-slate-50 px-4 py-3 rounded-2xl">
                                <a href="{{ route('profile.show', $comment->user) }}" class="font-bold text-sm text-slate-900 hover:text-blue-600 transition block mb-1">
                                    {{ $comment->user->full_name }}
                                </a>
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $comment->body }}</p>
                            </div>
                            <div class="flex items-center gap-4 mt-1 ml-2 text-xs text-slate-400">
                                 <span>{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-sm py-8">No comments yet. Be the first to say something!</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function restoreScrollPosition() {
            // This will be handled by the feed page on load
            return true;
        }

        // Like toggle function
        if (typeof window.toggleLike === 'undefined') {
            window.toggleLike = async function(postId, element) {
                try {
                    // Find the parent div with x-data
                    const container = element.closest('[x-data]');
                    if (!container) {
                        console.error('Alpine.js container not found');
                        return;
                    }

                    const response = await fetch(`/post/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    
                    // Update Alpine.js component data
                    const alpineData = Alpine.$data(container);
                    alpineData.liked = data.liked;
                    alpineData.count = data.count;
                } catch (error) {
                    console.error('Error toggling like:', error);
                }
            };
        }

        // Save scroll position function
        if (typeof window.saveScrollPosition === 'undefined') {
            window.saveScrollPosition = function() {
                sessionStorage.setItem('feedScrollPosition', window.scrollY);
            };
        }
    </script>
</x-app-layout>
