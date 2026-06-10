@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-2 sm:px-4">
    <div class="mb-6">
        <a href="{{ route('warehouses.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-900 transition-colors mb-3">
            <i class="fa-solid fa-arrow-left"></i> Back to Warehouses
        </a>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-boxes-stacked text-slate-700"></i> Stock Analytics: {{ $warehouse->name }}
                </h2>
                <p class="text-slate-500 mt-0.5 flex items-center gap-2">
                    <span class="bg-slate-200/80 text-slate-700 px-2 py-0.5 rounded text-xs font-mono font-medium">{{ $warehouse->code }}</span>
                    <span>|</span>
                    <i class="fa-solid fa-phone text-xs"></i> {{ $warehouse->phone ?? 'No contact line' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-cubes"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Unique Products</span>
                <span class="text-2xl font-bold text-slate-800">{{ $warehouse->products->count() }}</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Total Combined Stock</span>
                <span class="text-2xl font-bold text-slate-800">{{ $warehouse->products->sum('pivot.stock') }} Units</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Stock Assets Worth</span>
                <span class="text-2xl font-bold text-slate-800">
                    PKR {{ number_format($warehouse->products->sum(function($prod) { return $prod->sale_price * $prod->pivot->stock; }), 2) }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list text-slate-400 text-sm"></i> Itemized Inventory Manifest
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-4">Product Identity</th>
                        <th class="text-left px-6 py-4">SKU / Item-Code</th>
                        <th class="text-right px-6 py-4">Unit Price</th>
                        <th class="text-center px-6 py-4">Current Stock Status</th>
                        <th class="text-right px-6 py-4">Available Quantity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($warehouse->products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-slate-500">
                            {{ $product->sku ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-right font-medium text-slate-600">
                            PKR {{ number_format($product->sale_price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->pivot->stock > 20)
                                <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-medium border border-emerald-100">
                                    Good Stock
                                </span>
                            @elseif($product->pivot->stock > 0)
                                <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium border border-amber-100">
                                    Low Stock Warning
                                </span>
                            @else
                                <span class="bg-rose-50 text-rose-700 px-2.5 py-1 rounded-full text-xs font-medium border border-rose-100">
                                    Out Of Stock
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-base {{ $product->pivot->stock > 0 ? 'text-slate-800' : 'text-rose-500' }}">
                            {{ $product->pivot->stock }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fa-solid fa-boxes-packing text-3xl text-slate-300"></i>
                                <div>
                                    <p class="font-medium text-slate-500 text-base">This warehouse is entirely empty</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Approve purchase bills tracking to this location to fill layout stock.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection