@extends('layouts.app')

@section('content')

<div class="w-full mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-3xl font-bold flex items-center gap-2 text-slate-900">
                <i class="fa-solid fa-users text-indigo-600"></i>
                Users
            </h2>
            <p class="text-slate-500 mt-1">Manage staff accounts and roles</p>
        </div>

        <a href="{{ route('users.create') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow">
            <i class="fa-solid fa-user-plus"></i>
            Add User
        </a>
    </div>

    {{-- Toolbar --}}
    @include('partials.index-toolbar', ['placeholder' => 'Search users...'])

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left">

                {{-- Header --}}
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-slate-700 text-sm uppercase tracking-wide">
                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-user mr-2 text-slate-400"></i> Name
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-envelope mr-2 text-slate-400"></i> Email
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-shield-halved mr-2 text-slate-400"></i> Role
                        </th>

                        <th class="px-6 py-4 font-semibold text-right">
                            Actions
                        </th>
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($users as $user)

                        <tr class="hover:bg-indigo-50/40 transition">

                            {{-- Name --}}
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4 text-slate-600 text-sm">
                                {{ $user->email }}
                            </td>

                            {{-- Roles --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">No role</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm shadow transition">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this user?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm shadow transition">
                                                <i class="fa-solid fa-trash"></i>
                                                Delete
                                            </button>

                                        </form>
                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                <i class="fa-solid fa-user-slash text-2xl mb-2 block"></i>
                                No users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection