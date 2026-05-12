@extends('layouts.app')

@section('content')

<div class="mb-5">
    <h2 class="text-2xl font-bold">Edit Category</h2>
</div>

<form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div class="mb-4">
        <label class="block mb-1">Name</label>
        <input type="text" name="name"
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