<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-primary">
        <h1 class="text-7xl font-black text-primary">
            💍{{ config('app.name') }}.
        </h1>

        @if (Route::has('login'))
            <div class="flex items-center gap-2 mt-5">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 rounded-lg text-primary border border-primary/20 hover:bg-primary hover:text-white transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-lg text-primary border border-primary/20 hover:bg-primary hover:text-white transition">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 rounded-lg text-primary border border-primary/20 hover:bg-primary hover:text-white transition">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
</body>

</html>
