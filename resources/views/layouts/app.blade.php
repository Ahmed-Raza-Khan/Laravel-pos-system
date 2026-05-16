<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel POS system') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased bg-slate-100 text-slate-900">
        <div class="min-h-screen bg-slate-100">
            <!-- Sidebar (fixed) -->
            <div class="fixed left-0 top-0 h-screen w-72 bg-slate-950 text-slate-100 border-r border-slate-800 shadow-lg">
                @include('layouts.sidebar')
            </div>
            
            <!-- Main Wrapper (content scrolls) -->
            <div class="flex-1 flex flex-col ml-72">
                <!-- Top Navbar -->
                <div class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">
                    @include('layouts.navbar')
                </div>
                <!-- Page Content -->
                <main class="p-6 flex-1">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
