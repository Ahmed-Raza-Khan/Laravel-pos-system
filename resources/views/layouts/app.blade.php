<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel POS'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://kit.fontawesome.com/2c65a5c594.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased" x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' }">
    <section class="flex min-h-screen">
        <aside class="fixed inset-y-0 left-0 z-40 w-72 bg-slate-900 text-white border-r border-slate-800 shadow-2xl" :class="sidebarOpen ? 'sidebar-expanded' : 'sidebar-collapsed'" @mouseenter="sidebarOpen = true" @mouseleave="sidebarOpen = localStorage.getItem('sidebarOpen') === 'true'">
            @include('layouts.sidebar')
        </aside>
        
        <section class="flex flex-1 flex-col min-h-screen w-full" :class="sidebarOpen ? 'ml-expanded' : 'ml-collapsed'">
            <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl shadow-sm flex items-center gap-4 px-6 h-22">
                <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)" class="p-2 hover:bg-slate-100 rounded-lg transition">
                    <i :class="sidebarOpen ? 'fas fa-chevron-left' : 'fas fa-chevron-right'" class="text-slate-600"></i>
                </button>
                @include('layouts.navbar')
            </header>
            
            <main class="flex-1 p-6 lg:p-8">
                @include('partials.flash')
                
                @yield('content')
            </main>
        </section>
    </section>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
</body>
</html>
