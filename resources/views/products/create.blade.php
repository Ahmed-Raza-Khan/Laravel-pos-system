@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('products.index')])
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Create Product</h2>
                <p class="text-slate-500 mt-1">Add a new product with category, brand, stock, and image.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-3xl shadow-lg">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">Category</label>
                <select name="category_id" class="w-full border border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">Brand</label>
                <select name="brand_id" class="w-full border border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
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
        <button class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-white transition hover:bg-slate-800">
            Save Product
        </button>
    </form>
@endsection