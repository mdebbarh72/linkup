<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

        <style>
            body { font-family: 'Inter', sans-serif; }
            /* Soft Shadow Custom Utility */
            .shadow-soft {
                box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
            }
        </style>

        <!-- Scripts -->
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            slate: {
                                50: '#f8fafc',
                                900: '#0f172a',
                            }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased">
        
        @include('partials.header')

        <main>
            {{ $slot }}
        </main>

        @include('partials.footer')
    </body>
</html>
