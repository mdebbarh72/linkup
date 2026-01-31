<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        <div class="min-h-screen flex max-w-7xl mx-auto">
            <!-- Left Sidebar (Navigation) -->
            <aside class="w-64 shrink-0 hidden lg:block py-8 sticky top-0 h-screen overflow-y-auto border-r border-slate-100/50 pr-4 bg-white">
                @include('layouts.navigation')
            </aside>

            <!-- Main Content -->
            <main class="flex-1 w-full min-w-0 px-4 sm:px-6 lg:px-8 py-8">
                <!-- Mobile Header (Visible only on small screens) -->
                <div class="lg:hidden flex items-center justify-between bg-white/80 backdrop-blur-md sticky top-0 z-50 py-4 mb-6 -mx-4 px-4 border-b border-slate-100">
                    <a href="{{ route('feed') }}" class="font-bold text-xl tracking-tight text-slate-900">LinkUp</a>
                    <button @click="open = ! open" x-data="{ open: false }" class="text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                    <!-- Mobile Menu Overlay would go here, simplified for now to rely on standard nav if needed or just hide -->
                </div>

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
