<header class="fixed w-full z-50 top-4 px-4 sm:px-8">
    <nav class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md rounded-2xl shadow-sm px-6 py-4 flex justify-between items-center border border-slate-100">
        <a href="/" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">L</div>
            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-600">LinkUp</span>
        </a>

        <div class="hidden md:flex items-center gap-8 font-medium text-slate-500">
            <a href="#about" class="hover:text-blue-600 transition">About Us</a>
            <a href="#testimonials" class="hover:text-blue-600 transition">Stories</a>
            <a href="#contact" class="hover:text-blue-600 transition">Contact</a>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('feed') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/20">
                    Go to App
                </a>
            @else
                <a href="{{ route('login') }}" class="hidden md:block text-slate-600 font-medium hover:text-slate-900">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
                        Join Now
                    </a>
                @endif
            @endauth
        </div>
    </nav>
</header>
