<div>
    <div class="space-y-6">
        @forelse($posts as $post)
            <x-post-card :post="$post" wire:key="post-{{ $post->id }}" />
        @empty
            <div class="bg-white p-12 rounded-3xl shadow-sm text-center border border-slate-100 border-dashed">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">📝</div>
                <h3 class="text-lg font-bold text-slate-700 mb-2">No posts yet</h3>
                <p class="text-slate-500">This user hasn't shared anything yet.</p>
            </div>
        @endforelse
    </div>

    @if($hasMore)
        <div 
            id="load-more-trigger-profile"
            wire:ignore
            class="flex justify-center py-8"
        >
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let loading = false;
                const trigger = document.getElementById('load-more-trigger-profile');
                
                if (trigger) {
                    console.log('Profile infinite scroll initialized. Posts: {{ $posts->count() }}, Total: {{ $totalPosts }}');
                    
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && !loading) {
                                console.log('Loading more profile posts...');
                                loading = true;
                                
                                @this.call('loadMore').then(() => {
                                    console.log('Profile posts loaded');
                                    loading = false;
                                }).catch((error) => {
                                    console.error('Error loading profile posts:', error);
                                    loading = false;
                                });
                            }
                        });
                    }, { threshold: 0.1 });
                    
                    observer.observe(trigger);
                }
            });
        </script>
    @else
        <div class="text-center py-8 text-slate-500 text-sm">
            No more posts to load
        </div>
    @endif
</div>
