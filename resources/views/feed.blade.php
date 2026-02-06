<x-app-layout>
    <div class="py-24 max-w-2xl mx-auto px-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Your Feed</h1>
        </div>

        <!-- Create Post Shortcut -->
        <div class="mb-8">
             <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create-post')"
                class="w-full bg-white p-4 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition text-left group"
            >
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->first_name }}" class="w-12 h-12 rounded-full object-cover border border-slate-100">
                <div class="flex-1 bg-slate-50 rounded-2xl px-4 py-3 text-slate-400 group-hover:bg-slate-100 transition">
                    What's on your mind, {{ Auth::user()->first_name }}?
                </div>
                <div class="p-2 text-slate-400 group-hover:text-indigo-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
            </button>
        </div>

        <x-modal name="create-post" :show="$errors->any()" focusable>
            <x-create-post-form />
        </x-modal>

        @forelse($posts as $post)
            <x-post-card :post="$post" />
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

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>

    <script>
        // Restore scroll position when returning from post detail
        window.addEventListener('DOMContentLoaded', function() {
            const scrollPosition = sessionStorage.getItem('feedScrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
                sessionStorage.removeItem('feedScrollPosition');
            }
        });
    </script>
</x-app-layout>
