<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel POS'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body{font-family:'Instrument Sans',ui-sans-serif,system-ui,sans-serif}</style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <section class="flex min-h-screen">
        <aside class="fixed inset-y-0 left-0 z-40 w-72 bg-slate-900 text-white border-r border-slate-800 shadow-2xl">
            @include('layouts.sidebar')
        </aside>
        
        <section class="flex flex-1 flex-col ml-72 min-h-screen w-full">
            <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl shadow-sm">
                @include('layouts.navbar')
            </header>
            
            <main class="flex-1 p-6 lg:p-8">
                @include('partials.flash')
                
                @yield('content')
            </main>
        </section>
    </section>
</body>
</html>
