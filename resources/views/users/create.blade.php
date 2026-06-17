@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-4 py-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('users.index')])
            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fa-solid fa-user-plus text-indigo-500"></i>
                    Create User
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-indigo-400 text-sm"></i>
                    Create a new staff account with roles and permissions
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('users.store') }}" method="POST" 
          class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fa-solid fa-user text-indigo-500 mr-2"></i>
                    Full Name
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Enter full name"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('name')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fa-solid fa-envelope text-indigo-500 mr-2"></i>
                    Email Address
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="user@example.com"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fa-solid fa-lock text-indigo-500 mr-2"></i>
                    Password
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password"
                           placeholder="Enter password (min 8 chars)"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fa-solid fa-lock text-indigo-500 mr-2"></i>
                    Confirm Password
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fa-solid fa-check-circle"></i>
                    </span>
                    <input type="password" name="password_confirmation"
                           placeholder="Confirm password"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fa-solid fa-shield-halved text-indigo-500 mr-2"></i>
                    Role
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fa-solid fa-user-tag"></i>
                    </span>
                    <select name="role"
                            class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 appearance-none bg-white">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                    <span class="absolute right-3 top-3 text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
                @error('role')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">Role determines what permissions the user will have</p>
            </div>

            <!-- Permissions Preview -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fa-solid fa-key text-indigo-500 mr-2"></i>
                    Permissions Preview
                </label>
                <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-4 border border-slate-200 min-h-[52px] flex items-center">
                    <div class="flex flex-wrap gap-1.5">
                        <span class="text-sm text-slate-500">
                            <i class="fa-solid fa-info-circle text-indigo-400 mr-1"></i>
                            Permissions will be auto-assigned based on role
                        </span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-1">Roles define permission sets</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 pt-6 border-t-2 border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-6 py-3 text-slate-700 hover:bg-slate-200 transition-all duration-300">
                <i class="fa-solid fa-times"></i>
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                <i class="fa-solid fa-save"></i>
                Create User
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    select {
        background-image: none;
    }
    input:focus, select:focus {
        outline: none;
    }
    .hover\:scale-\[1\.02\] {
        transition: transform 0.3s ease;
    }
    .hover\:scale-\[1\.02\]:hover {
        transform: scale(1.02);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endpush