<nav class="space-y-8">
    <!-- Brand -->
    <div class="px-4 mb-8">
        <a href="{{ route('feed') }}" class="flex items-center gap-3">
            <div class="bg-slate-900 text-white p-2 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            </div>
            <span class="font-bold text-2xl tracking-tight text-slate-900">LinkUp</span>
        </a>
    </div>

    <!-- User Snippet -->
    <div class="px-4 text-center">
        <div class="relative inline-block">
             <div class="absolute inset-0 bg-gradient-to-tr from-violet-500 to-fuchsia-500 rounded-full blur opacity-25"></div>
             <img src="{{ Auth::user()->avatar_url }}" class="relative w-24 h-24 rounded-full object-cover border-4 border-white shadow-sm mb-3 mx-auto">
        </div>
        <h3 class="font-bold text-lg text-slate-900">{{ Auth::user()->full_name }}</h3>
        <p class="text-sm text-slate-500 font-medium pb-4 border-b border-slate-100 mb-4">{{ Auth::user()->profile->pseudo ? '@'.Auth::user()->profile->pseudo : Auth::user()->email }}</p>
        
        <div class="flex justify-center gap-6 text-sm">
            <div class="text-center">
                <span class="block font-bold text-slate-900">{{ Auth::user()->posts()->count() }}</span>
                <span class="text-slate-400 text-xs">Posts</span>
            </div>
            <div class="text-center">
                <span class="block font-bold text-slate-900">{{ Auth::user()->friendsCount() }}</span>
                <span class="text-slate-400 text-xs">Friends</span>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="space-y-1 px-2">
        <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition duration-200 {{ request()->routeIs('profile.show') && request()->route('user')->id === Auth::id() ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-sm' }}">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span class="font-bold text-sm">My Profile</span>
        </a>

        <a href="{{ route('feed') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition duration-200 {{ request()->routeIs('feed') ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-sm' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            <span class="font-bold text-sm">Feed</span>
        </a>

        <a href="{{ route('friends.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition duration-200 {{ request()->routeIs('friends.*') ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-sm' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="font-bold text-sm">Friends</span>
        </a>

        <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition duration-200 {{ request()->routeIs('search') ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-sm' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <span class="font-bold text-sm">Search</span>
        </a>
    </div>

    <!-- Logout -->
    <div class="px-4 mt-auto pt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-2xl w-full text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <span class="font-bold text-sm">Log Out</span>
            </button>
        </form>
    </div>
</nav>
