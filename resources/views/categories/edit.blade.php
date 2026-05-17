@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-1 py-1">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Edit Category</h2>
                <p class="text-slate-500 mt-1">Update the category name and visibility in your inventory.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-white transition hover:bg-slate-800">
                ← Back to Categories
            </a>
        </div>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Category name">
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-2xl transition">
                    Update Category
                </button>
            </div>
        </form>
    </div>
@endsection