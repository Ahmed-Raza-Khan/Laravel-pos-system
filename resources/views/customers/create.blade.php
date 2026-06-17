@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('customers.index')])
            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-user-plus text-indigo-500"></i>
                    Create Customer
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-address-book text-indigo-400 text-sm"></i>
                    Add a new customer to your database
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('customers.store') }}" method="POST" 
          class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Name -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-user text-indigo-500 mr-2"></i>
                    Full Name
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           placeholder="Enter customer full name"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('name')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                    Email Address
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           placeholder="customer@example.com"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-phone text-indigo-500 mr-2"></i>
                    Phone Number
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           placeholder="+1 234 567 8900"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('phone')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                    Address
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-map-pin"></i>
                    </span>
                    <textarea name="address" rows="3" 
                              placeholder="Enter customer address"
                              class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 resize-none">{{ old('address') }}</textarea>
                </div>
                @error('address')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-toggle-on text-indigo-500 mr-2"></i>
                    Status
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-circle"></i>
                    </span>
                    <select name="status" 
                            class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 appearance-none bg-white">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    <span class="absolute right-3 top-3 text-slate-400 pointer-events-none">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>
                @error('status')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">Active customers can make purchases and access their account</p>
            </div>

            <!-- Customer Since Preview -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-calendar-plus text-indigo-500 mr-2"></i>
                    Customer Since
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-calendar"></i>
                    </span>
                    <input type="text" 
                           value="{{ now()->format('d M Y') }}" 
                           readonly
                           class="w-full bg-gray-50 border-2 border-slate-200 p-3 pl-10 rounded-xl text-slate-500 cursor-not-allowed">
                    <span class="absolute right-3 top-3 text-slate-400">
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Customer will be created with today's date</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 pt-6 border-t-2 border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('customers.index') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-6 py-3 text-slate-700 hover:bg-slate-200 transition-all duration-300">
                <i class="fas fa-times"></i>
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                <i class="fas fa-save"></i>
                Save Customer
            </button>
        </div>
    </form>
@endsection

@push('styles')
<style>
    select {
        background-image: none;
    }
    
    input:focus, textarea:focus, select:focus {
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
    
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    
    input:read-only {
        cursor: not-allowed;
    }
    
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    textarea::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    textarea::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush