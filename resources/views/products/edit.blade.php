@extends('layouts.app')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-bold">Edit Product</h2>
    </div>

    <form method="POST" action="{{ route('products.update', $product->id) }}"
        class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full border p-2 rounded">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Product Name</label>
            <input type="text" name="name"
                class="w-full border p-2 rounded"
                value="{{ old('name', $product->name) }}">

            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Price</label>
            <input type="text" name="price"
                class="w-full border p-2 rounded"
                value="{{ old('price', $product->price) }}">

            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Stock</label>
            <input type="number" name="stock"
                class="w-full border p-2 rounded"
                value="{{ old('stock', $product->stock) }}">

            @error('stock')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            @error('status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-yellow-500 text-white px-4 py-2 rounded">
                Update Product
            </button>

            <a href="{{ route('products.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded">
                Cancel
            </a>
        </div>
    </form>
@endsection