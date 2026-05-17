@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-1 py-1">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Edit Brand</h2>
                <p class="text-slate-500 mt-1">Update the brand name, description and status.</p>
            </div>
            <a href="{{ route('brands.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-white transition hover:bg-slate-800">
                ← Back to Brands
            </a>
        </div>

        <form action="{{ route('brands.update', $brand->id) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Brand Name</label>
                <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Brand name">
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Brand description">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-2xl transition">
                    Update Brand
                </button>
            </div>
        </form>
    </div>
@endsection