<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">Find People</h1>
            
            <form action="{{ route('search') }}" method="GET" class="w-full md:w-96 relative">
                <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search by pseudo or email..." class="w-full pl-12 pr-4 py-3 rounded-xl bg-white border border-slate-200 focus:outline-none focus:border-blue-500 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-3.5 text-slate-400 w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </form>
        </div>

        @if($users->isEmpty() && isset($query))
            <div class="bg-white p-12 rounded-3xl shadow-soft text-center border border-slate-100">
                <p class="text-slate-500 text-lg">No users found matching "{{ $query }}"</p>
            </div>
        @elseif($users->isEmpty())
             <div class="bg-white p-12 rounded-3xl shadow-soft text-center border border-slate-100">
                <p class="text-slate-500 text-lg">Type a name to start searching...</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($users as $user)
                    <a href="{{ route('profile.show', $user) }}" class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200 transition duration-300 flex flex-col items-center group">
                        <div class="relative mb-3">
                             <img src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}" class="w-20 h-20 rounded-full object-cover border-2 border-slate-100">
                        </div>
                        
                        <h3 class="font-bold text-base text-slate-900 mb-0.5 text-center group-hover:text-blue-600 transition">{{ $user->full_name }}</h3>
                        <p class="text-xs text-indigo-600 font-medium mb-3">{{ $user->profile->pseudo ? '@'.$user->profile->pseudo : 'New Member' }}</p>
                        
                        <p class="text-slate-500 text-xs mb-4 line-clamp-2 px-2 text-center h-8">
                            {{ $user->profile->bio }}
                        </p>

                        <div class="w-full mt-auto" onclick="event.stopPropagation(); event.preventDefault();">
                            @if(Auth::id() !== $user->id)
                                @if(Auth::user()->isFriendWith($user))
                                    <button disabled class="w-full py-2 rounded-lg bg-emerald-50 text-emerald-700 font-semibold text-xs border border-emerald-100 flex items-center justify-center gap-1.5 opacity-80">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        Friends
                                    </button>
                                @elseif(Auth::user()->hasPendingRequestTo($user))
                                    <button disabled class="w-full py-2 rounded-lg bg-slate-100 text-slate-500 font-semibold text-xs border border-slate-200 flex items-center justify-center gap-1.5 opacity-80">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Requested
                                    </button>
                                @elseif(Auth::user()->hasPendingRequestFrom($user))
                                     <a href="{{ route('friends.index') }}" class="block w-full py-2 rounded-lg bg-indigo-50 text-indigo-700 font-semibold text-xs border border-indigo-100 text-center hover:bg-indigo-100 transition">
                                        Respond
                                    </a>
                                @else
                                    <form action="{{ route('friends.request', $user) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full py-2 rounded-lg bg-slate-900 text-white font-semibold text-xs hover:bg-slate-800 transition shadow-sm flex items-center justify-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                                            Connect
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('profile.edit') }}" class="block w-full py-2 rounded-lg bg-white border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition text-center">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
