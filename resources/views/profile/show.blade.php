<x-app-layout>
    <!-- Profile Header -->
    <div class="bg-white border-b border-slate-100">
        <div class="max-w-4xl mx-auto pt-24 pb-12 px-6">
             <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- Avatar -->
                <div class="relative shrink-0">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                </div>

                <!-- Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row items-center gap-4 mb-4">
                        <h1 class="text-3xl font-bold text-slate-900">{{ $user->full_name }}</h1>
                        @if($user->profile->pseudo)
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold">@ {{ $user->profile->pseudo }}</span>
                        @endif
                    </div>

                    @if($user->profile->bio)
                        <p class="text-slate-600 max-w-2xl mb-6">{{ $user->profile->bio }}</p>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center justify-center md:justify-start gap-8 mb-8 border-y border-slate-50 py-4 md:border-none md:py-0">
                        <div class="text-center md:text-left">
                            <div class="text-2xl font-bold text-slate-900">{{ $postsCount }}</div>
                            <div class="text-sm text-slate-500 font-medium">Posts</div>
                        </div>
                        <div class="text-center md:text-left">
                            <div class="text-2xl font-bold text-slate-900">{{ $friendsCount }}</div>
                            <div class="text-sm text-slate-500 font-medium">Friends</div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    @if(Auth::id() !== $user->id)
                         @if(Auth::user()->isFriendWith($user))
                            <button class="px-6 py-2.5 rounded-xl bg-green-100 text-green-700 font-bold hover:bg-green-200 transition">
                                Friends
                            </button>
                        @elseif(Auth::user()->hasPendingRequestTo($user))
                            <button class="px-6 py-2.5 rounded-xl bg-slate-100 text-slate-500 font-bold" disabled>
                                Request Sent
                            </button>
                        @elseif(Auth::user()->hasPendingRequestFrom($user))
                             <a href="{{ route('friends.index') }}" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                                Respond
                            </a>
                        @else
                            <form action="{{ route('friends.request', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/10">
                                    Send Request
                                </button>
                            </form>
                        @endif
                    @else
                         <a href="{{ route('profile.edit') }}" class="px-6 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition border border-slate-200">
                            Edit Profile
                        </a>
                    @endif
                </div>
             </div>
        </div>
    </div>

    <!-- Posts Feed -->
    <div class="bg-slate-50 min-h-screen py-12 px-6">
        <div class="max-w-2xl mx-auto">
            @if(Auth::id() === $user->id)
                <div class="mb-8">
                    <x-create-post-form />
                </div>
            @endif

            <h2 class="text-xl font-bold text-slate-800 mb-6 px-2">Recent Posts</h2>
            
            @forelse($posts as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="bg-white p-12 rounded-3xl shadow-sm text-center border border-slate-100 border-dashed">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">📝</div>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">No posts yet</h3>
                    <p class="text-slate-500">This user hasn't shared anything yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
