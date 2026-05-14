@extends('layouts.app')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-bold">Edit Product</h2>
    </div>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data"
        class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">

            {{-- Category --}}
            <div>
                <label class="block mb-1">Category</label>
                <select name="category_id" class="w-full border p-2 rounded">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Brand --}}
            <div>
                <label class="block mb-1">Brand</label>
                <select name="brand_id" class="w-full border p-2 rounded">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Product Name --}}
            <div>
                <label class="block mb-1">Product Name</label>
                <input type="text" name="name"
                    class="w-full border p-2 rounded"
                    value="{{ old('name', $product->name) }}">

                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- SKU --}}
            <div>
                <label class="block mb-1">SKU</label>
                <input type="text" name="sku"
                    class="w-full border p-2 rounded"
                    value="{{ old('sku', $product->sku) }}">

                @error('sku')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Barcode --}}
            <div>
                <label class="block mb-1">Barcode</label>
                <input type="text" name="barcode"
                    class="w-full border p-2 rounded"
                    value="{{ old('barcode', $product->barcode) }}">

                @error('barcode')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Purchase Price --}}
            <div>
                <label class="block mb-1">Purchase Price</label>
                <input type="number" name="purchase_price"
                    class="w-full border p-2 rounded"
                    value="{{ old('purchase_price', $product->purchase_price) }}">

                @error('purchase_price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sale Price --}}
            <div>
                <label class="block mb-1">Sale Price</label>
                <input type="number" name="sale_price"
                    class="w-full border p-2 rounded"
                    value="{{ old('sale_price', $product->sale_price) }}">

                @error('sale_price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stock --}}
            <div>
                <label class="block mb-1">Stock</label>
                <input type="number" name="stock"
                    class="w-full border p-2 rounded"
                    value="{{ old('stock', $product->stock) }}">

                @error('stock')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image --}}
            <div>
                <label class="block mb-1">Product Image</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
                @error('image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}"
                            class="w-20 h-20 object-cover rounded border">
                    </div>
                @endif
            </div>

            {{-- Status --}}
            <div>
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

        </div>

        {{-- Description --}}
        <div class="mt-4">
            <label class="block mb-1">Description</label>
            <textarea name="description"
                class="w-full border p-2 rounded">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="flex gap-3 mt-5">
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