<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Create Post -->
            <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-200">
                <div class="flex gap-4 mb-4">
                    <img src="{{ Auth::user()->avatar_url }}" class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1 bg-slate-50 rounded-2xl px-4 py-2.5 text-slate-500 cursor-text hover:bg-slate-100 transition">
                        What's on your mind, {{ Auth::user()->first_name }}?
                    </div>
                </div>
                <div class="flex justify-between items-center border-t border-slate-100 pt-3">
                    <div class="flex gap-2">
                            <button class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-rose-50 text-slate-500 hover:text-rose-600 transition text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-rose-500"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            Photo
                            </button>
                            <button class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-blue-50 text-slate-500 hover:text-blue-600 transition text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            Video
                            </button>
                    </div>
                    <button class="px-6 py-2 rounded-xl bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 transition">
                        Post
                    </button>
                </div>
            </div>

            <!-- Right Sidebar (Widgets) -->
            <div class="hidden lg:block space-y-6">
                <p class="text-slate-500">No posts yet.</p>
            </div>
        </div>
    </div>
</x-app-layout>
