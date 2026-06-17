@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('brands.index')])
            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-plus-circle text-indigo-500"></i>
                    Create Brand
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-building text-indigo-400 text-sm"></i>
                    Add a new brand to organize your products
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('brands.store') }}" method="POST" class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Brand Name -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-tag text-indigo-500 mr-2"></i>
                    Brand Name
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-building"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           placeholder="Enter brand name (e.g., Nike, Apple, Samsung)"
                           class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                </div>
                @error('name')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">This will be used to generate a unique slug for the brand</p>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-align-left text-indigo-500 mr-2"></i>
                    Description
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-pencil-alt"></i>
                    </span>
                    <textarea name="description" rows="4" 
                              placeholder="Enter brand description (optional)"
                              class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 resize-none">{{ old('description') }}</textarea>
                </div>
                @error('description')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">Provide a brief description of the brand (optional)</p>
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
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                            <i class="fas fa-check-circle text-green-500"></i> Active
                        </option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                            <i class="fas fa-times-circle text-red-500"></i> Inactive
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
                <p class="text-xs text-slate-400 mt-1">Active brands will be visible in your product catalog</p>
            </div>

            <!-- Slug Preview (Auto-generated) -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-link text-indigo-500 mr-2"></i>
                    Slug Preview
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <i class="fas fa-link"></i>
                    </span>
                    <input type="text" 
                           value="{{ old('name') ? Str::slug(old('name')) : 'auto-generated-slug' }}" 
                           readonly
                           class="w-full bg-gray-50 border-2 border-slate-200 p-3 pl-10 rounded-xl text-slate-500 cursor-not-allowed">
                    <span class="absolute right-3 top-3 text-slate-400">
                        <i class="fas fa-sync-alt"></i>
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Slug is automatically generated from the brand name</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 pt-6 border-t-2 border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('brands.index') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-6 py-3 text-slate-700 hover:bg-slate-200 transition-all duration-300">
                <i class="fas fa-times"></i>
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                <i class="fas fa-save"></i>
                Save Brand
            </button>
        </div>
    </form>
@endsection

@push('styles')
<style>
    /* Custom select styling */
    select {
        background-image: none;
    }
    
    /* Input focus effects */
    input:focus, textarea:focus, select:focus {
        outline: none;
    }
    
    /* Hover animation for buttons */
    .hover\:scale-\[1\.02\] {
        transition: transform 0.3s ease;
    }
    .hover\:scale-\[1\.02\]:hover {
        transform: scale(1.02);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
    
    /* Readonly field styling */
    input:read-only {
        cursor: not-allowed;
    }
    
    /* Textarea resize handler */
    textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    /* Custom scrollbar for textarea */
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
    
    /* Form field animation */
    .form-field {
        animation: fadeInUp 0.5s ease forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Loading state for submit button */
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.8;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-left: 8px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush