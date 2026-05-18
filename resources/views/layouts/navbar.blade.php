@php
    $user = auth()->user();
    $initials = collect(explode(' ', $user->name ?? 'U'))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
    $roleName = $user->roles->first()?->name ?? 'User';
@endphp
<nav class="flex items-center justify-between gap-4 px-6 py-4">
    <section>
        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">POS Panel</p>
        <h1 class="text-lg font-bold text-slate-900 capitalize">{{ str_replace(['.', '-'], ' ', request()->route()?->getName() ?? 'dashboard') }}</h1>
    </section>

    <section class="flex items-center gap-4">
        {{-- <a href="{{ route('profile.edit') }}" class="hidden md:flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 hover:border-indigo-300 hover:bg-indigo-50 transition">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-sm font-bold text-white shadow">{{ $initials }}</span>
            <span class="text-left">
                <span class="block text-sm font-semibold text-slate-900">{{ $user->name }}</span>
                <span class="block text-xs text-slate-500">{{ $roleName }} · {{ $user->email }}</span>
            </span>
        </a> --}}

        <x-dropdown align="right" width="56">
            <x-slot name="trigger">
                <button type="button" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg hover:bg-slate-800 transition">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-500 text-xs font-bold">{{ $initials }}</span>
                    <span class="hidden sm:inline">{{ $user->name }}</span>
                    <svg class="h-4 w-4 opacity-70" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </x-slot>
            
            <x-slot name="content">
                <section class="px-4 py-3 border-b border-slate-100">
                    <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    <span class="mt-1 inline-flex rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-semibold text-indigo-700">{{ $roleName }}</span>
                </section>
                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile Settings') }}</x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </section>
</nav>
