<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Find People</h2>
                <p class="text-slate-500 mb-8">Search for friends by name, username, or email.</p>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <form action="{{ route('search.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        
                        <div class="md:col-span-5">
                            <label for="pseudo" class="block text-sm font-medium text-slate-700 mb-2 ml-1">Username / Pseudo</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <input type="text" name="pseudo" id="pseudo" placeholder="e.g. AlexDev" 
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-blue-500 rounded-xl transition-all duration-200"
                                    value="{{ request('pseudo') }}">
                            </div>
                        </div>

                        <div class="md:col-span-5">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2 ml-1">Email Address</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                <input type="email" name="email" id="email" placeholder="e.g. alex@example.com" 
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-blue-500 rounded-xl transition-all duration-200"
                                    value="{{ request('email') }}">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="w-full py-3 px-6 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-slate-900/20 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($users as $user)
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 flex flex-col items-center text-center group">
                        
                        <div class="relative mb-4">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 p-1">
                                <img class="w-full h-full rounded-full object-cover border-4 border-white" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name) }}&background=random" 
                                     alt="{{ $user->full_name }}">
                            </div>
                            </div>

                        <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $user->full_name }}</h3>
                        
                        <p class="text-sm text-slate-500 mb-6">
                            {{ $user->profile && $user->profile->pseudo ? '@' . $user->profile->pseudo : '@' . Str::slug($user->full_name) }}
                        </p>

                        <div class="w-full space-y-3 mt-auto">
                            <form action="{{ route('friend-requests.send', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-50 text-blue-600 font-semibold hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center gap-2 group-hover:bg-blue-600 group-hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    Add Friend
                                </button>
                            </form>

                            <button disabled class="w-full py-2.5 rounded-xl border border-slate-200 text-slate-400 font-medium cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Message (Soon)
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No users found</h3>
                        <p class="text-slate-500 mt-2">Try adjusting your search terms to find who you're looking for.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>