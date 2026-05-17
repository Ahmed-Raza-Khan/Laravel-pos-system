@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ $product->name }}</h1>
                <p class="text-slate-500 mt-1">A full overview of this product with image, pricing, stock, barcode and metadata.</p>
            </div>

            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl shadow-sm transition">
                ← Back to Products
            </a>
        </div>

        <div class="grid gap-8 xl:grid-cols-[420px_minmax(0,1fr)]">
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="relative h-96 bg-slate-100 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full items-center justify-center text-slate-400">
                            No product image available
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">{{ $product->name }}</h2>
                            <p class="text-sm text-slate-500 mt-1">{{ $product->category->name ?? 'No category' }} • {{ $product->brand->name ?? 'No brand' }}</p>
                        </div>
                        <div class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <h3 class="text-sm text-slate-500 uppercase tracking-wide">Product ID</h3>
                            <p class="mt-2 font-semibold text-slate-900">#{{ $product->id }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <h3 class="text-sm text-slate-500 uppercase tracking-wide">Image File</h3>
                            <p class="mt-2 font-semibold text-slate-900">{{ basename($product->image ?? '') ?: 'N/A' }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <h3 class="text-sm text-slate-500 uppercase tracking-wide">SKU</h3>
                            <p class="mt-2 font-semibold text-slate-900">{{ $product->sku }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <h3 class="text-sm text-slate-500 uppercase tracking-wide">Stock</h3>
                            <p class="mt-2 font-semibold text-slate-900">{{ $product->stock }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl border border-slate-200 shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-slate-900">Pricing & Inventory</h2>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <p class="text-sm text-slate-500">Purchase Price</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">PKR {{ number_format($product->purchase_price, 0) }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <p class="text-sm text-slate-500">Sale Price</p>
                            <p class="mt-2 text-lg font-semibold text-emerald-700">PKR {{ number_format($product->sale_price, 0) }}</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-3xl bg-slate-50 p-5">
                        <div class="flex items-center justify-between text-sm text-slate-500">
                            <span>Created</span>
                            <span>{{ $product->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm text-slate-500">
                            <span>Updated</span>
                            <span>{{ $product->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-xl font-semibold text-slate-900">Barcode</h2>
                    <p class="text-sm text-slate-500 mt-2">Scan or print this barcode for inventory labels and receipts.</p>

                    <div class="mt-5 rounded-3xl bg-slate-50 p-5 text-center">
                        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 2, 60) !!}
                        <p class="mt-4 text-sm font-semibold text-slate-900">{{ $product->barcode }}</p>
                    </div>

                    <div class="mt-6 text-right">
                        <a href="{{ route('products.barcode', $product->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl transition">
                            Print Barcode
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection