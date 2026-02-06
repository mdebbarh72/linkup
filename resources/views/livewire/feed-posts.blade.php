<div>
    <div class="space-y-6">
        @forelse($posts as $post)
            <x-post-card :post="$post" wire:key="post-{{ $post->id }}" />
        @empty
            <div class="bg-white p-12 rounded-3xl shadow-soft text-center border border-slate-100">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">📭</div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">It's quiet here...</h2>
                <p class="text-slate-500">Add friends to see their stories and updates!</p>
                <a href="{{ route('search') }}" class="inline-block mt-6 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-500 transition shadow-lg shadow-blue-600/20">
                    Find Friends
                </a>
            </div>
        @endforelse
    </div>

    @if($hasMore)
        <div 
            id="load-more-trigger"
            wire:ignore
            class="flex justify-center py-8"
        >
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let loading = false;
                const trigger = document.getElementById('load-more-trigger');
                
                if (trigger) {
                    console.log('Infinite scroll initialized. Posts: {{ $posts->count() }}, Total: {{ $totalPosts }}');
                    
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && !loading) {
                                console.log('Loading more posts...');
                                loading = true;
                                
                                @this.call('loadMore').then(() => {
                                    console.log('Posts loaded successfully');
                                    loading = false;
                                }).catch((error) => {
                                    console.error('Error loading posts:', error);
                                    loading = false;
                                });
                            }
                        });
                    }, { threshold: 0.1 });
                    
                    observer.observe(trigger);
                    console.log('Observer attached to element');
                }
            });
        </script>
    @else
        <div class="text-center py-8 text-slate-500 text-sm">
            No more posts to load
        </div>
    @endif
</div>
