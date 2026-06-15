@extends('layouts.app')

@section('content')

<div class="w-full mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-3xl font-bold flex items-center gap-2 text-slate-900">
                <i class="fa-solid fa-boxes-stacked text-indigo-600"></i>
                Products
            </h2>
            <p class="text-slate-500 mt-1">
                Manage product catalog, stock, and pricing from one place.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap gap-2">

            <a href="{{ route('products.export') }}"
               class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold">
                <i class="fa-solid fa-file-export"></i>
                Export
            </a>

            <a href="{{ route('products.import') }}"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-2xl text-sm font-semibold">
                <i class="fa-solid fa-file-import"></i>
                Import
            </a>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold shadow">
                <i class="fa-solid fa-plus"></i>
                Add Product
            </a>

        </div>
    </div>

    {{-- Search --}}
    @include('partials.index-toolbar', ['placeholder' => 'Search name, SKU, barcode...'])

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px] text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-50 text-slate-700">
                    <tr class="border-b border-slate-200">

                        @include('partials.sortable-th', ['field' => 'id', 'label' => '#'])

                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-box mr-2 text-slate-400"></i>
                            Product
                        </th>

                        @include('partials.sortable-th', ['field' => 'category', 'label' => 'Category'])

                        @include('partials.sortable-th', ['field' => 'purchase_price', 'label' => 'Purchase'])

                        @include('partials.sortable-th', ['field' => 'sale_price', 'label' => 'Sale'])

                        @include('partials.sortable-th', ['field' => 'stock', 'label' => 'Stock'])

                        <th class="px-6 py-4 font-semibold">Status</th>

                        <th class="px-6 py-4 font-semibold text-right">Actions</th>

                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($products as $product)

                        <tr class="hover:bg-indigo-50/40 transition">

                            {{-- ID --}}
                            <td class="px-6 py-4 text-slate-500">
                                #{{ $product->id }}
                            </td>

                            {{-- PRODUCT --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    {{-- Avatar / Image --}}
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold">
                                        {{ strtoupper(substr($product->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            {{ $product->sku ?? 'No SKU' }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- CATEGORY --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-tags text-[10px]"></i>
                                    {{ $product->category->name ?? '-' }}
                                </span>
                            </td>

                            {{-- PURCHASE --}}
                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $setting->currency ?? 'PKR' }}
                                {{ number_format($product->purchase_price, 0) }}
                            </td>

                            {{-- SALE --}}
                            <td class="px-6 py-4 font-medium text-green-600">
                                {{ $setting->currency ?? 'PKR' }}
                                {{ number_format($product->sale_price, 0) }}
                            </td>

                            {{-- STOCK --}}
                            <td class="px-6 py-4">

                                @if($product->total_stock > 10)
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                        {{ $product->total_stock }}
                                    </span>

                                @elseif($product->total_stock > 0)
                                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                        {{ $product->total_stock }}
                                    </span>

                                @else
                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-xmark text-[10px]"></i>
                                        Out
                                    </span>
                                @endif

                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                @if($product->status)
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('products.show', $product->id) }}"
                                       class="bg-slate-700 hover:bg-slate-800 text-white px-3 py-2 rounded-xl text-xs">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>

                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-xl text-xs">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Delete this product?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-xs">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                                <i class="fa-solid fa-box-open text-2xl mb-2 block"></i>
                                No products found. Start by adding your first product.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    <div>
        {{ $products->links() }}
    </div>

</div>

@endsection