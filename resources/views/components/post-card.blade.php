@props(['post'])

<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-6 transition hover:shadow-md" x-data="{ showComments: false }">
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

                @if(Auth::id() === $post->user_id)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                        </button>
                        
                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-10" style="display: none;">
                            <button 
                                x-on:click="$dispatch('open-modal', 'edit-post-{{ $post->id }}'); open = false"
                                class="w-full text-left px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                Edit Post
                            </button>
                            <button 
                                x-on:click="$dispatch('open-modal', 'delete-post-{{ $post->id }}'); open = false"
                                class="w-full text-left px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 flex items-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                Delete Post
                            </button>
                        </div>
                    </div>
                @endif
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
        <button class="flex items-center gap-2 text-slate-500 hover:text-red-500 transition group">
            <div class="p-2 rounded-full group-hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="heart-icon"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </div>
            <span class="font-medium text-sm">{{ $post->likes_count }} Likes</span>
        </button>

        <button @click="showComments = !showComments" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition group">
            <div class="p-2 rounded-full group-hover:bg-blue-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
             <span class="font-medium text-sm">{{ $post->comments_count }} Comments</span>
        </button>
    </div>

    <!-- Comments Section -->
    <div x-show="showComments" x-transition class="pt-4 mt-4 border-t border-slate-50">
        <!-- Add Comment Form (Visual Only) -->
        <div class="flex gap-3 mb-6">
            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->full_name }}" class="w-8 h-8 rounded-full object-cover">
            <div class="flex-1">
                <form class="relative" action="{{ route('comment.create') }}" method="post">
                    <input 
                        type="text" 
                        placeholder="Write a comment..." 
                        class="w-full bg-slate-50 border-none rounded-2xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-100 placeholder:text-slate-400"
                    >
                    <button type="submit" class="absolute right-2 top-1.5 p-1 text-slate-400 hover:text-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Comments List -->
        <div class="space-y-4">
            @forelse($post->comments as $comment)
                <div class="flex gap-3">
                    <a href="{{ route('profile.show', $comment->user) }}">
                        <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->full_name }}" class="w-8 h-8 rounded-full object-cover hover:opacity-80 transition">
                    </a>
                    <div class="flex-1">
                        <div class="bg-slate-50 px-4 py-2 rounded-2xl inline-block">
                            <a href="{{ route('profile.show', $comment->user) }}" class="font-bold text-sm text-slate-900 hover:text-blue-600 transition block">
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
                <p class="text-center text-slate-400 text-sm py-2">No comments yet. Be the first to say something!</p>
            @endforelse
        </div>
    </div>

    <!-- Modals (Rendered only for Owner) -->
    @if(Auth::id() === $post->user_id)
        <!-- Edit Modal -->
        <x-modal name="edit-post-{{ $post->id }}" focusable>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 max-w-2xl mx-auto transition-shadow hover:shadow-md">
                <form action="{{ route('post.update', $post) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex gap-4">
                        <div class="shrink-0">
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->full_name }}" class="w-12 h-12 rounded-full object-cover border border-slate-100">
                        </div>
                        
                        <div class="flex-1">
                            <textarea 
                                name="content" 
                                rows="3" 
                                placeholder="What's on your mind, {{ Auth::user()->first_name }}?" 
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-slate-800 placeholder:text-slate-400 resize-none transition-all duration-200"
                            >{{ old('content', $post->content) }}</textarea>
                            
                            @error('content')
                                <p class="text-rose-500 text-sm mt-1 mb-2">{{ $message }}</p>
                            @enderror

                            <!-- Existing Images -->
                            @if($post->images->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mt-4 mb-2" id="existing-images-{{ $post->id }}">
                                    @foreach($post->images as $image)
                                        <div class="relative w-24 h-24 rounded-xl overflow-hidden border border-slate-100 shrink-0" id="image-wrapper-{{ $image->id }}">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover">
                                            
                                            <button type="button" 
                                                onclick="markImageForRemoval(this,{{ $image->id }})"
                                                class="absolute top-1 right-1 p-1 bg-rose-500 text-white rounded-full shadow-md hover:bg-rose-600 transition-colors z-10"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="removed-images-container-{{ $post->id }}"></div>
                            @endif

                            <!-- Image Preview Container -->
                            <div id="image-preview-container-{{ $post->id }}" class="hidden mt-4 flex flex-wrap gap-2">
                                    <!-- Images will be injected here -->
                            </div>

                            <div class="flex items-center justify-between pt-4 mt-2 border-t border-slate-50">
                                <div class="flex items-center gap-2">
                                    <label class="flex items-center gap-2 px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition cursor-pointer group">
                                        <div class="p-1.5 rounded-full bg-slate-100 group-hover:bg-indigo-50 text-slate-500 group-hover:text-indigo-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                        </div>
                                        <span class="font-bold text-sm">Photos</span>
                                        <input type="file" id="image-input-{{ $post->id }}" name="images[]" class="hidden" accept="image/*" multiple onchange="previewPostImages(event, {{ $post->id }})">
                                    </label>
                                </div>

                                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-900/10 hover:shadow-indigo-500/20 transform hover:-translate-y-0.5 active:translate-y-0">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-modal>

        <!-- Delete Modal -->
        <x-modal name="delete-post-{{ $post->id }}">
            <div class="p-6 text-center">
                <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Delete Post?</h2>
                <p class="text-slate-500 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>
                
                <div class="flex justify-center gap-3">
                    <button x-on:click="$dispatch('close')" class="px-6 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition">
                        Cancel
                    </button>
                    <form action="{{ route('post.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2.5 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-700 transition shadow-lg shadow-rose-600/20">
                            Delete Post
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
    @endif
</div>



<script>
    if (typeof window.markImageForRemoval === 'undefined') {
        window.markImageForRemoval = function(button, imageId) {
           const wrapper = button.closest('[id^="image-wrapper-"]');
           if (wrapper) {
                const form = wrapper.closest('form');
                if (form) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_images[]';
                    input.value = imageId;
                    form.appendChild(input);
                    wrapper.remove();
                }
           }
        };
    }
    
    // Ensure previewPostImages is also only defined once if it wasn't already
    if (typeof window.previewPostImages === 'undefined') {
        window.previewPostImages = function(event, postId) {
            const files = event.target.files;
            // Use the specific ID if postId is provided, otherwise fall back to relative search
            let container;
            if (postId) {
                container = document.getElementById(`image-preview-container-${postId}`);
            } else {
                // Fallback for creation form if it doesn't pass ID
                const input = event.target;
                const form = input.closest('form');
                container = form.querySelector('[id^="image-preview-container"]');
            }
            
            if (!container) return;
            
            // Clear previous previews
            container.innerHTML = '';
            
            if (files && files.length > 0) {
                container.classList.remove('hidden');
                
                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-24 h-24 rounded-xl overflow-hidden border border-slate-100 shrink-0';
                    
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                    `;
                    container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }
        };
    }

</script>