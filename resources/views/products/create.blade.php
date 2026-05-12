@extends('layouts.app')

@section('content')

<div class="mb-5">
    <h2 class="text-2xl font-bold">Create Product</h2>
</div>

<form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf

    <!-- Category -->
    <div class="mb-4">
        <label class="block mb-1">Category</label>
        <select name="category_id" class="w-full border p-2 rounded">
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Name -->
    <div class="mb-4">
        <label class="block mb-1">Product Name</label>
        <input type="text" name="name"
               class="w-full border p-2 rounded"
               value="{{ old('name') }}"
               placeholder="Enter product name">

        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price -->
    <div class="mb-4">
        <label class="block mb-1">Price</label>
        <input type="text" name="price"
               class="w-full border p-2 rounded"
               value="{{ old('price') }}"
               placeholder="Enter price">

        @error('price')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Stock -->
    <div class="mb-4">
        <label class="block mb-1">Stock</label>
        <input type="number" name="stock"
               class="w-full border p-2 rounded"
               value="{{ old('stock') }}"
               placeholder="Enter stock quantity">

        @error('stock')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>

        @error('status')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit -->
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
        Save Product
    </button>
</form>

@endsection