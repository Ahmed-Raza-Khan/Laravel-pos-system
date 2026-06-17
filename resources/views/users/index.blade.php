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
            <p class="text-slate-500 mt-1 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-indigo-400 text-sm"></i>
                Manage staff accounts, roles and permissions
            </p>
        </div>

        <div class="flex gap-3">
            {{-- Manage Role Permissions Dropdown --}}
            <div class="relative group">
                <button class="inline-flex items-center gap-2 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 shadow-lg shadow-purple-200 transition-all duration-300">
                    <i class="fa-solid fa-shield-halved"></i>
                    Manage Roles
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    @php
                        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();
                    @endphp
                    @foreach($roles as $role)
                        <a href="{{ route('roles.permissions', $role) }}" 
                        class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-user-tag text-indigo-400"></i>
                            {{ $role->name }}
                            <span class="ml-auto text-xs text-slate-400">{{ $role->users->count() }} users</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Add User --}}
            <a href="{{ route('users.create') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                <i class="fa-solid fa-user-plus"></i>
                Add User
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    @include('partials.index-toolbar', ['placeholder' => 'Search users...'])

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr class="text-slate-700 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-user mr-2 text-indigo-400"></i> User
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-envelope mr-2 text-indigo-400"></i> Email
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-shield-halved mr-2 text-indigo-400"></i> Roles
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-key mr-2 text-indigo-400"></i> Permissions
                        </th>
                        <th class="px-6 py-4 font-semibold text-right">
                            <i class="fa-solid fa-cog mr-2 text-indigo-400"></i> Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-indigo-50/40 transition-all duration-200 group">
                            {{-- User --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-400">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                                    <i class="fa-solid fa-envelope text-xs text-slate-400"></i>
                                    {{ $user->email }}
                                </span>
                            </td>

                            {{-- Roles --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">No role assigned</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Permissions --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @php
                                        $permissions = $user->getAllPermissions();
                                    @endphp
                                    @forelse($permissions->take(3) as $permission)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-medium rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-check-circle text-[8px]"></i>
                                            {{ str_replace(' ', '', ucwords(str_replace('_', ' ', $permission->name))) }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">No permissions</span>
                                    @endforelse
                                    @if($permissions->count() > 3)
                                        <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-medium rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                            +{{ $permissions->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.permissions', $user) }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white transition-all duration-300 group-hover:scale-105">
                                        <i class="fa-solid fa-key text-sm"></i>
                                    </a>

                                    <a href="{{ route('users.edit', $user) }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 group-hover:scale-105">
                                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 group-hover:scale-105">
                                                <i class="fa-solid fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-users text-3xl text-slate-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-700 mb-1">No Users Found</h3>
                                    <p class="text-sm text-slate-500">Create your first user to start managing staff</p>
                                    <a href="{{ route('users.create') }}"
                                       class="mt-4 inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-sm text-white hover:bg-indigo-700 transition-colors">
                                        <i class="fa-solid fa-user-plus"></i>
                                        Add User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-slate-500">
            Showing <span class="font-semibold text-slate-700">{{ $users->firstItem() ?? 0 }}</span>
            to <span class="font-semibold text-slate-700">{{ $users->lastItem() ?? 0 }}</span>
            of <span class="font-semibold text-slate-700">{{ $users->total() }}</span> users
        </p>
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .pagination .page-item {
        list-style: none;
    }
    .pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.75rem;
        border-radius: 0.75rem;
        border: 2px solid #e2e8f0;
        color: #475569;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: white;
    }
    .pagination .page-link:hover {
        border-color: #6366f1;
        color: #6366f1;
        transform: scale(1.05);
    }
    .pagination .active .page-link {
        background: #6366f1;
        border-color: #6366f1;
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    .pagination .page-link i {
        font-size: 0.75rem;
    }
    
    .group {
        transition: all 0.3s ease;
    }
    .group:hover {
        transform: translateX(4px);
    }
    
    .hover\:scale-\[1\.02\] {
        transition: transform 0.3s ease;
    }
    .hover\:scale-\[1\.02\]:hover {
        transform: scale(1.02);
    }
</style>
@endpush