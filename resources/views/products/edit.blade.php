@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('products.index')])
            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-edit text-indigo-500"></i>
                    Edit Product
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-pen text-indigo-400 text-sm"></i>
                    Update product details, pricing, inventory, and image.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data"
        class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Category --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-tags text-indigo-500 mr-2"></i>Category
                </label>
                <select name="category_id"
                    class="select2 w-full border-2 border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                    <option value="">Select Category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Brand --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-building text-indigo-500 mr-2"></i>Brand
                </label>
                <select name="brand_id"
                    class="select2 w-full border-2 border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Product Name --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-pencil-alt text-indigo-500 mr-2"></i>Product Name
                </label>
                <input type="text" name="name" placeholder="Enter product name"
                    class="w-full border-2 border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                    value="{{ old('name', $product->name) }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- SKU --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-barcode text-indigo-500 mr-2"></i>SKU
                </label>
                <div class="relative">
                    <input type="text" name="sku" readonly
                        class="w-full bg-gray-50 border-2 border-slate-200 p-3 rounded-xl text-slate-500 cursor-not-allowed"
                        value="{{ old('sku', $product->sku) }}">
                    <i class="fas fa-lock text-slate-400 absolute right-3 top-3"></i>
                </div>
                @error('sku')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Barcode --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-qrcode text-indigo-500 mr-2"></i>Barcode
                </label>
                <div class="relative">
                    <input type="text" name="barcode" readonly
                        class="w-full bg-gray-50 border-2 border-slate-200 p-3 rounded-xl text-slate-500 cursor-not-allowed"
                        value="{{ old('barcode', $product->barcode) }}">
                    <i class="fas fa-lock text-slate-400 absolute right-3 top-3"></i>
                </div>
                @error('barcode')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Purchase Price --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-shopping-cart text-indigo-500 mr-2"></i>Purchase Price
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-500">$</span>
                    <input type="number" name="purchase_price" placeholder="0.00" step="0.01"
                        class="w-full border-2 border-slate-200 p-3 pl-8 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                        value="{{ old('purchase_price', $product->purchase_price) }}">
                </div>
                @error('purchase_price')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Sale Price --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-tag text-indigo-500 mr-2"></i>Sale Price
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-500">$</span>
                    <input type="number" name="sale_price" placeholder="0.00" step="0.01"
                        class="w-full border-2 border-slate-200 p-3 pl-8 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                        value="{{ old('sale_price', $product->sale_price) }}">
                </div>
                @error('sale_price')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Stock --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-warehouse text-indigo-500 mr-2"></i>Stock Quantity
                </label>
                <input type="number" name="stock" placeholder="Enter stock quantity"
                    class="w-full border-2 border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                    value="{{ old('stock', $product->total_stock) }}">
                @error('stock')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Image --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-image text-indigo-500 mr-2"></i>Product Image
                </label>
                <div
                    class="relative border-2 border-dashed border-slate-300 rounded-xl p-4 hover:border-indigo-500 transition-all duration-300">
                    <input type="file" name="image" accept="image/*"
                        class="w-full opacity-0 absolute inset-0 cursor-pointer">
                    <div class="text-center">
                        <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 mb-2"></i>
                        <p class="text-slate-500">Click or drag to update image</p>
                        <p class="text-xs text-slate-400">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror

                @if ($product->image)
                    <div class="mt-3 flex items-center gap-3">
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-20 h-20 object-cover rounded-xl border-2 border-slate-200 shadow-sm">
                            <div class="absolute -top-2 -right-2 bg-green-500 rounded-full p-1">
                                <i class="fas fa-check-circle text-white text-xs"></i>
                            </div>
                        </div>
                        <span class="text-sm text-slate-500">Current image</span>
                    </div>
                @endif
            </div>

            {{-- Status --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-toggle-on text-indigo-500 mr-2"></i>Status
                </label>
                <select name="status"
                    class="w-full border-2 border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300">
                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                        <i class="fas fa-check-circle text-green-500"></i> Active
                    </option>
                    <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                        <i class="fas fa-times-circle text-red-500"></i> Inactive
                    </option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description (Full Width) --}}
            <div class="col-span-1 md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-align-left text-indigo-500 mr-2"></i>Description
                </label>
                <textarea name="description" rows="4" placeholder="Enter product description..."
                    class="w-full border-2 border-slate-200 p-3 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 resize-none">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 pt-6 border-t-2 border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-6 py-3 text-slate-700 hover:bg-slate-200 transition-all duration-300">
                <i class="fas fa-times"></i>
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                <i class="fas fa-sync-alt"></i>
                Update Product
            </button>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        .select2-container--default .select2-selection--single {
            border: 2px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem !important;
            height: 52px !important;
            transition: all 0.3s ease !important;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 3px !important;
            right: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8 !important;
        }

        .select2-dropdown {
            border: 2px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            margin-top: 4px !important;
        }

        .select2-search__field {
            border: 2px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem !important;
        }

        .select2-results__option--highlighted {
            background: #6366f1 !important;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
        }

        /* Custom file input hover effect */
        .border-dashed:hover {
            border-color: #6366f1 !important;
            background-color: #f8fafc;
        }

        /* Image preview badge animation */
        .group:hover .fa-check-circle {
            transform: scale(1.2);
            transition: transform 0.2s ease;
        }
    </style>
@endpush
