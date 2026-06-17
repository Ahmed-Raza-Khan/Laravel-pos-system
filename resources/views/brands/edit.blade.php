@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-1 py-1">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-edit text-indigo-500"></i>
                    Edit Brand
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-pen text-indigo-400 text-sm"></i>
                    Update the brand name, description and status
                </p>
            </div>
            <a href="{{ route('brands.index') }}" 
               class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-white transition hover:bg-slate-800 shadow-lg shadow-slate-200">
                <i class="fas fa-arrow-left"></i>
                Back to Brands
            </a>
        </div>

        <form action="{{ route('brands.update', $brand->id) }}" method="POST" 
              class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
            @csrf
            @method('PUT')

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
                        <input type="text" name="name" value="{{ old('name', $brand->name) }}" 
                               placeholder="Enter brand name"
                               class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1">Current slug: <span class="font-mono">{{ $brand->slug }}</span></p>
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
                                  placeholder="Enter brand description"
                                  class="w-full border-2 border-slate-200 p-3 pl-10 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 resize-none">{{ old('description', $brand->description) }}</textarea>
                    </div>
                    @error('description')
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
                            <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>
                                <i class="fas fa-check-circle text-green-500"></i> Active
                            </option>
                            <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>
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
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-xs text-slate-500">Current status:</span>
                        @if($brand->status)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700">
                                <i class="fas fa-circle text-[6px] text-emerald-500"></i>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-bold text-slate-700">
                                <i class="fas fa-circle text-[6px] text-slate-500"></i>
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Meta Info -->
                <div class="md:col-span-1">
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                        Brand Information
                    </label>
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-4 border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-hashtag text-indigo-400 text-xs"></i>
                                ID
                            </span>
                            <span class="font-semibold text-slate-900">#{{ $brand->id }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-calendar-plus text-indigo-400 text-xs"></i>
                                Created
                            </span>
                            <span class="font-semibold text-slate-900">{{ $brand->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-calendar-alt text-indigo-400 text-xs"></i>
                                Updated
                            </span>
                            <span class="font-semibold text-slate-900">{{ $brand->updated_at->format('d M Y, h:i A') }}</span>
                        </div>
                        @if($brand->created_at->diffInDays(now()) < 7)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 flex items-center gap-1">
                                    <i class="fas fa-clock text-indigo-400 text-xs"></i>
                                    Age
                                </span>
                                <span class="font-semibold text-emerald-600">{{ $brand->created_at->diffForHumans() }}</span>
                            </div>
                        @endif
                    </div>
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
                    <i class="fas fa-sync-alt"></i>
                    Update Brand
                </button>
            </div>
        </form>
    </div>
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
    
    /* Meta info card hover effect */
    .bg-gradient-to-br {
        background-size: 200% 200%;
        transition: background-position 0.5s ease;
    }
    .bg-gradient-to-br:hover {
        background-position: right center;
    }
    
    /* Current status badge pulse animation */
    .fa-circle {
        animation: pulse-dot 2s ease-in-out infinite;
    }
    
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
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
</style>
@endpush