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
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-gray-100">
            <!-- Sidebar -->
            <div class="w-64 bg-white border-r">
                @include('layouts.sidebar')
            </div>
            
            <!-- Main Wrapper -->
            <div class="flex-1 flex flex-col">
                <!-- Top Navbar -->
                <div class="bg-white shadow">
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
