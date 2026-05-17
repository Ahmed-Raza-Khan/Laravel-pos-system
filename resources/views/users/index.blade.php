@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <section>
        <h2 class="text-3xl font-bold text-slate-900">Users</h2>
        <p class="text-slate-500 mt-1">Manage staff accounts and roles</p>
    </section>

    <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl shadow-sm transition mt-4 sm:mt-0">
        ➕ Add User
    </a>
</div>

@if(session('success'))
    <section class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</section>
@endif
@if(session('error'))
    <section class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</section>
@endif

<section class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
    <section class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white text-black text-left">
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Role</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($users as $user)
                    <tr class="hover:bg-indigo-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @foreach($user->roles as $role)
                                <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold text-indigo-700">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-right">
                            <section class="inline-flex items-center gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">✎ Edit</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">🗑 Delete</button>
                                    </form>
                                @endif
                            </section>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</section>
@endsection
