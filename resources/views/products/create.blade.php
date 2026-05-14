@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-5">Create Product</h2>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
    @csrf

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label>Category</label>
            <select name="category_id" class="w-full border p-2 rounded">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Brand</label>
            <input type="text" name="brand_id" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>SKU</label>
            <input type="text" name="sku" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Barcode</label>
            <input type="text" name="barcode" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Purchase Price</label>
            <input type="number" name="purchase_price" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Sale Price</label>
            <input type="number" name="sale_price" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Stock</label>
            <input type="number" name="stock" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Image</label>
            <input type="file" name="image" class="w-full border p-2 rounded">
        </div>

        <div class="col-span-2">
            <label>Description</label>
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>

        <div>
            <label>Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

    </div>

    <button class="mt-5 bg-blue-500 text-white px-4 py-2 rounded">
        Save Product
    </button>
</form>

@endsection