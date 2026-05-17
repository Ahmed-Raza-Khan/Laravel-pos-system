@extends('layouts.app')

@section('content')

<section class="flex items-center justify-between mb-6">
    <section class="flex items-center gap-4">
        @include('partials.back-button', ['href' => route('users.index')])
        <h2 class="text-2xl font-bold">Edit User</h2>
    </section>
</section>

<form action="{{ route('users.update', $user) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg border border-slate-100 w-full">
    @csrf
    @method('PUT')

    <section class="mb-4">
        <label class="block mb-1 font-semibold text-slate-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2">
        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </section>

    <section class="mb-4">
        <label class="block mb-1 font-semibold text-slate-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2">
        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </section>

    <section class="mb-4">
        <label class="block mb-1 font-semibold text-slate-700">New Password <span class="text-slate-400 font-normal">(leave blank to keep)</span></label>
        <input type="password" name="password" class="w-full border border-slate-200 rounded-lg px-3 py-2">
        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </section>

    <section class="mb-4">
        <label class="block mb-1 font-semibold text-slate-700">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full border border-slate-200 rounded-lg px-3 py-2">
    </section>

    <section class="mb-6">
        <label class="block mb-1 font-semibold text-slate-700">Role</label>
        <select name="role" class="w-full border border-slate-200 rounded-lg px-3 py-2">
            @foreach($roles as $role)
                <option value="{{ $role }}" {{ old('role', $user->roles->first()?->name) === $role ? 'selected' : '' }}>{{ $role }}</option>
            @endforeach
        </select>
        @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </section>

    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl font-semibold">Update User</button>
</form>
@endsection
