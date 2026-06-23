@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-box text-indigo-500"></i>
                    {{ $product->name }}
                </h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-info-circle text-indigo-400 text-sm"></i>
                    A full overview of this product with image, pricing, stock, barcode and metadata.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('products.edit', $product->id) }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-white transition hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                    <i class="fas fa-edit"></i>
                    Edit Product
                </a>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-white transition hover:bg-slate-800">
                    <i class="fas fa-arrow-left"></i>
                    Back to Products
                </a>
            </div>
        </div>

        <div class="grid gap-8 xl:grid-cols-[420px_minmax(0,1fr)]">
            <!-- Left Column - Product Image & Basic Info -->
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                <div class="relative h-96 bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full p-2 shadow-lg">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    @else
                        <div class="flex h-full flex-col items-center justify-center text-slate-400">
                            <i class="fas fa-image text-6xl mb-4 opacity-50"></i>
                            <p>No product image available</p>
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                                {{ $product->name }}
                                @if ($product->status)
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        Inactive
                                    </span>
                                @endif
                            </h2>
                            <p class="text-sm text-slate-500 mt-1 flex items-center gap-2 flex-wrap">
                                @if ($product->category)
                                    <span class="inline-flex items-center gap-1 me-3">
                                        Category : 
                                        <i class="fas fa-tag text-indigo-400 text-xs"></i>
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                                @if ($product->brand)
                                    <span class="inline-flex items-center gap-1">
                                        Brand : 
                                        <i class="fas fa-building text-indigo-400 text-xs"></i>
                                        {{ $product->brand->name }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-4 border border-slate-200">
                            <h3 class="text-xs text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                <i class="fas fa-hashtag text-indigo-400"></i>
                                Product ID
                            </h3>
                            <p class="mt-2 font-semibold text-slate-900">#{{ $product->id }}</p>
                        </div>
                        <div class="rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-4 border border-slate-200">
                            <h3 class="text-xs text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                <i class="fas fa-barcode text-indigo-400"></i>
                                SKU
                            </h3>
                            <p class="mt-2 font-semibold text-slate-900">{{ $product->sku }}</p>
                        </div>
                        <div class="rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-4 border border-slate-200">
                            <h3 class="text-xs text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                <i class="fas fa-warehouse text-indigo-400"></i>
                                Stock
                            </h3>
                            <p class="mt-2 font-semibold text-slate-900">
                                @if ($product->total_stock > 10)
                                    <span class="text-emerald-600">{{ $product->total_stock }}</span>
                                @elseif($product->total_stock > 0)
                                    <span class="text-amber-600">{{ $product->total_stock }}</span>
                                @else
                                    <span class="text-red-600">{{ $product->total_stock }}</span>
                                @endif
                                <span class="text-sm font-normal text-slate-500">units</span>
                            </p>
                        </div>
                        <div class="rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-4 border border-slate-200">
                            <h3 class="text-xs text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                <i class="fas fa-qrcode text-indigo-400"></i>
                                Barcode
                            </h3>
                            <p class="mt-2 font-semibold text-slate-900 text-sm">{{ $product->barcode }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Pricing, Inventory & Barcode -->
            <div class="space-y-6">
                <!-- Pricing & Inventory -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-chart-line text-indigo-500"></i>
                        Pricing & Inventory
                    </h2>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-5 border border-slate-200">
                            <p class="text-sm text-slate-500 flex items-center gap-1">
                                <i class="fas fa-shopping-cart text-indigo-400"></i>
                                Purchase Price
                            </p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">
                                <span class="text-sm text-slate-500">{{ $setting->currency ?? 'PKR' }}</span>
                                {{ number_format($product->purchase_price, 0) }}
                            </p>
                        </div>
                        <div
                            class="rounded-3xl bg-gradient-to-br from-emerald-50 to-emerald-100 p-5 border border-emerald-200">
                            <p class="text-sm text-slate-500 flex items-center gap-1">
                                <i class="fas fa-tag text-emerald-500"></i>
                                Sale Price
                            </p>
                            <p class="mt-2 text-lg font-semibold text-emerald-700">
                                <span class="text-sm text-emerald-500">{{ $setting->currency ?? 'PKR' }}</span>
                                {{ number_format($product->sale_price, 0) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-5 border border-slate-200">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-calendar-plus text-indigo-400"></i>
                                Created
                            </span>
                            <span
                                class="font-medium text-slate-700">{{ $product->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-calendar-alt text-indigo-400"></i>
                                Updated
                            </span>
                            <span
                                class="font-medium text-slate-700">{{ $product->updated_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-clock text-indigo-400"></i>
                                Time ago
                            </span>
                            <span class="font-medium text-slate-700">{{ $product->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Barcode Section -->
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6">
                    <h2 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-qrcode text-indigo-500"></i>
                        Barcode
                    </h2>
                    <p class="text-sm text-slate-500 mt-2 flex items-center gap-1">
                        <i class="fas fa-info-circle text-indigo-400"></i>
                        Scan or print this barcode for inventory labels and receipts.
                    </p>

                    <div
                        class="mt-5 rounded-3xl bg-gradient-to-br from-slate-50 to-slate-100 p-6 text-center border border-slate-200">
                        <div class="inline-block bg-white p-4 rounded-xl shadow-sm">
                            {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 2, 60) !!}
                        </div>
                        <p class="mt-4 font-semibold text-slate-900 flex items-center justify-center gap-2">
                            <i class="fas fa-barcode text-indigo-400"></i>
                            {{ $product->barcode }}
                        </p>
                        <p class="text-xs text-slate-400 mt-1">Code 128 format</p>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('products.barcode', $product->id) }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-slate-900 shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300 text-white">
                            <i class="fas fa-print"></i>
                            Print Barcode
                        </a>
                        <button onclick="window.print()"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-6 py-3 text-slate-700 hover:bg-slate-200 transition-all duration-300">
                            <i class="fas fa-file-pdf"></i>
                            Save as PDF
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-slate-900 flex items-center gap-2 mb-4">
                        <i class="fas fa-bolt text-indigo-500"></i>
                        Quick Actions
                    </h2>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('products.edit', $product->id) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-50 px-4 py-3 text-indigo-700 hover:bg-indigo-100 transition-all duration-300 border border-indigo-200">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 transition-all duration-300 border border-slate-200">
                            <i class="fas fa-list"></i>
                            All Products
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="col-span-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-red-50 px-4 py-3 text-red-600 hover:bg-red-100 transition-all duration-300 border border-red-200"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fas fa-trash-alt"></i>
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .bg-white {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
            }
        }

        /* Smooth hover effects */
        .hover\:scale-\[1\.02\] {
            transition: transform 0.3s ease;
        }

        .hover\:scale-\[1\.02\]:hover {
            transform: scale(1.02);
        }

        /* Gradient backgrounds for cards */
        .bg-gradient-to-br {
            background-size: 200% 200%;
            transition: background-position 0.5s ease;
        }

        .bg-gradient-to-br:hover {
            background-position: right center;
        }

        /* Barcode container styling */
        .inline-block svg {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush
