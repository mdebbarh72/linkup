<x-app-layout>
    <div x-data="{ activeTab: 'friends', showModal: false, selectedRequest: null }" class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-6 tracking-tight">Connections</h1>

        <!-- Tabs -->
        <div class="flex gap-2 p-1 bg-slate-100/80 rounded-xl mb-8 w-fit">
            <button @click="activeTab = 'friends'" :class="activeTab === 'friends' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg font-semibold text-sm transition-all duration-200">
                Friends
                <span :class="activeTab === 'friends' ? 'bg-slate-100 text-slate-600' : 'bg-slate-200 text-slate-500'" class="ml-2 py-0.5 px-2 rounded-md text-xs align-middle transition-colors">{{ count($friends) }}</span>
            </button>
            <button @click="activeTab = 'requests'" :class="activeTab === 'requests' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg font-semibold text-sm transition-all duration-200">
                Requests
                @if($requests->count() > 0)
                    <span :class="activeTab === 'requests' ? 'bg-rose-100 text-rose-600' : 'bg-white/50 text-slate-500'" class="ml-2 py-0.5 px-2 rounded-md text-xs align-middle transition-colors">{{ $requests->count() }}</span>
                @endif
            </button>
        </div>

        <!-- My Friends List -->
        <div x-show="activeTab === 'friends'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            @forelse($friends as $friend)
                <a href="{{ route('profile.show', $friend) }}" class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200 transition duration-300 flex items-center gap-3 group">
                    <img src="{{ $friend->avatar_url }}" class="w-12 h-12 rounded-full object-cover border border-slate-100">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 truncate text-sm group-hover:text-blue-600 transition">{{ $friend->full_name }}</h3>
                        <p class="text-slate-500 text-xs truncate">{{ $friend->profile->pseudo ? '@'.$friend->profile->pseudo : '' }}</p>
                    </div>
                    <!-- Actions Menu -->
                   <form action="{{ route('friends.remove', $friend->id) }}" method="POST" class="relative z-10">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="event.preventDefault(); event.stopPropagation(); if(confirm('Are you sure you want to remove this friend?')) this.closest('form').submit();" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition border border-transparent hover:border-rose-100">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 18 18"/></svg>
                        </button>
                   </form>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-xl border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="text-slate-900 font-medium mb-1">No friends yet</p>
                    <p class="text-slate-500 text-sm mb-4">You haven't added anyone to your list.</p>
                    <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                        Find people
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Friend Requests List -->
        <div x-show="activeTab === 'requests'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            @forelse($requests as $request)
                <div 
                    @click="showModal = true; selectedRequest = {{ json_encode(['id' => $request->id, 'sender' => $request->sender, 'avatar' => $request->sender->avatar_url, 'pseudo' => $request->sender->profile->pseudo]) }}"
                    class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition duration-300 flex items-center gap-3 cursor-pointer group hover:border-indigo-100"
                >
                    <div class="relative shrink-0">
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
                        <img src="{{ $request->sender->avatar_url }}" class="w-12 h-12 rounded-full object-cover border border-slate-100">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 truncate text-sm group-hover:text-indigo-600 transition">{{ $request->sender->full_name }}</h3>
                        <p class="text-slate-500 text-xs">Wants to connect</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl border border-slate-200 p-12 text-center">
                     <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                    </div>
                    <p class="text-slate-900 font-medium mb-1">All caught up</p>
                    <p class="text-slate-500 text-sm">No pending friend requests.</p>
                </div>
            @endforelse
        </div>

        <!-- Modal -->
        <div 
            x-show="showModal" 
            class="fixed inset-0 z-[100] flex items-center justify-center px-4"
            style="display: none;"
        >
            <!-- Backdrop -->
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="showModal = false"
                class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
            ></div>

            <!-- Modal Content -->
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden"
            >
                <div class="p-6 text-center" x-data>
                     <img :src="selectedRequest?.avatar" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-4 border-slate-50">
                     <h3 class="text-xl font-bold text-slate-900" x-text="selectedRequest?.sender.first_name + ' ' + selectedRequest?.sender.last_name"></h3>
                     <p class="text-slate-500 text-sm mb-6" x-text="selectedRequest?.pseudo ? '@' + selectedRequest?.pseudo : ''"></p>
                     
                     <div class="flex flex-col gap-3">
                        <a :href="'/profile/' + selectedRequest?.sender.id" class="w-full py-2.5 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 transition text-center">
                            View Profile
                        </a>
                        <div class="grid grid-cols-2 gap-3">
                            <form :action="'/friends/' + selectedRequest?.id + '/accept'" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 text-white font-semibold text-sm hover:bg-slate-800 transition">
                                    Accept
                                </button>
                            </form>
                            <form :action="'/friends/' + selectedRequest?.id + '/refuse'" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition">
                                    Ignore
                                </button>
                            </form>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Toast Notification (Check Session) -->
        @if (session('status'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 3000)"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3"
            >
                <span class="text-green-400">✓</span>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif
    </div>
</x-app-layout>
