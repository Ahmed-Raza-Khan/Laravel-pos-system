@extends('layouts.app')

@section('content')
<section class="w-full mx-auto px-4 py-6">

    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Stock Report</h1>
        <p class="text-gray-500 mt-1">Inventory levels and valuation</p>
    </section>

    @include('reports.partials.nav')

    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <section class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl shadow-lg p-6 border border-green-200">
            <p class="text-green-600 text-sm font-semibold uppercase">Total Stock Units</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($current_stock_count) }}</p>
        </section>
        <section class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-3xl shadow-lg p-6 border border-amber-200">
            <p class="text-amber-600 text-sm font-semibold uppercase">Low Stock (≤{{ $low_stock_threshold }})</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $low_stock->count() }}</p>
        </section>
        <section class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl shadow-lg p-6 border border-indigo-200">
            <p class="text-indigo-600 text-sm font-semibold uppercase">Inventory Valuation</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">PKR {{ number_format($inventory_valuation, 0) }}</p>
        </section>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <section class="bg-white rounded-3xl shadow-lg p-6 border border-red-100">
            <h2 class="text-lg font-bold text-red-700 mb-4">Out of Stock ({{ $out_of_stock->count() }})</h2>
            <section class="space-y-2 max-h-64 overflow-y-auto">
                @forelse($out_of_stock as $product)
                    <section class="flex justify-between items-center p-3 bg-red-50 rounded-xl">
                        <span class="font-medium">{{ $product->name }}</span>
                        <span class="text-red-600 font-bold text-sm">{{ $product->stock }} left</span>
                    </section>
                @empty
                    <p class="text-slate-500 text-sm">No out-of-stock products.</p>
                @endforelse
            </section>
        </section>
        <section class="bg-white rounded-3xl shadow-lg p-6 border border-amber-100">
            <h2 class="text-lg font-bold text-amber-700 mb-4">Low Stock ({{ $low_stock->count() }})</h2>
            <section class="space-y-2 max-h-64 overflow-y-auto">
                @forelse($low_stock as $product)
                    <section class="flex justify-between items-center p-3 bg-amber-50 rounded-xl">
                        <span class="font-medium">{{ $product->name }}</span>
                        <span class="text-amber-700 font-bold text-sm">{{ $product->stock }} left</span>
                    </section>
                @empty
                    <p class="text-slate-500 text-sm">No low-stock alerts.</p>
                @endforelse
            </section>
        </section>
    </section>

    <section class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <section class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Current Stock</h2>
        </section>
        <section class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold">SKU</th>
                        <th class="px-6 py-4 font-semibold">Category</th>
                        <th class="px-6 py-4 font-semibold text-right">Stock</th>
                        <th class="px-6 py-4 font-semibold text-right">Purchase Price</th>
                        <th class="px-6 py-4 font-semibold text-right">Value</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($products as $product)
                        @php
                            $status = $product->stock <= 0 ? 'out' : ($product->stock <= $low_stock_threshold ? 'low' : 'ok');
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $product->sku }}</td>
                            <td class="px-6 py-4">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-right font-semibold">{{ $product->stock }}</td>
                            <td class="px-6 py-4 text-right">PKR {{ number_format($product->purchase_price, 0) }}</td>
                            <td class="px-6 py-4 text-right">PKR {{ number_format($product->stock * $product->purchase_price, 0) }}</td>
                            <td class="px-6 py-4">
                                @if($status === 'out')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">Out</span>
                                @elseif($status === 'low')
                                    <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-xs font-bold">Low</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-bold">OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>
</section>
@endsection
