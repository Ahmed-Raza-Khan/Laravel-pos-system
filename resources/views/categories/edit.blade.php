@extends('layouts.app')

@section('content')

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Edit Category</h2>
        <p class="text-slate-500 mt-1">Update the category name and visibility in your inventory.</p>
    </div>
    <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-white transition hover:bg-slate-800">
        Back to categories
    </a>
</div>

<form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('categories.index')])
            <div>
                <h2 class="text-2xl font-bold">Edit Category</h2>
            </div>
        </div>
    </div>
               class="w-full border p-2 rounded"
               value="{{ old('name', $category->name) }}">

        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select name="status" class="w-full border p-2 rounded">

            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

        @error('status')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-yellow-500 text-white px-4 py-2 rounded">
        Update Category
    </button>
</form>

@endsection