@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-2 sm:px-4">
    <div class="mb-6">
        <a href="{{ route('warehouses.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-3">
            <i class="fa-solid fa-arrow-left"></i> Back to Warehouses
        </a>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-warehouse text-indigo-600"></i> 
                    {{ $warehouse->name }}
                </h2>
                <div class="flex flex-wrap items-center gap-3 mt-1">
                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-mono font-medium border border-slate-200">
                        <i class="fa-solid fa-tag text-slate-400"></i>
                        {{ $warehouse->code }}
                    </span>
                    @if ($warehouse->phone)
                        <span class="inline-flex items-center gap-1.5 text-sm text-slate-500">
                            <i class="fa-solid fa-phone text-indigo-400"></i>
                            {{ $warehouse->phone }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5">
                        @if ($warehouse->status)
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 px-3 py-1 rounded-full text-xs font-medium border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> 
                                Inactive
                            </span>
                        @endif
                    </span>
                </div>
                @if($warehouse->address)
                    <p class="text-slate-500 text-sm mt-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-indigo-400"></i>
                        {{ $warehouse->address }}
                    </p>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('warehouses.edit', $warehouse->id) }}" 
                   class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-white transition hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-edit"></i>
                    Edit Warehouse
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-cubes"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Unique Products</span>
                <span class="text-2xl font-bold text-slate-800">{{ $warehouse->products->count() }}</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Total Stock</span>
                <span class="text-2xl font-bold text-slate-800">{{ $warehouse->products->sum('pivot.stock') }} Units</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Stock Value</span>
                <span class="text-2xl font-bold text-slate-800">
                    PKR {{ number_format($warehouse->products->sum(function($prod) { return $prod->sale_price * $prod->pivot->stock; }), 0) }}
                </span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-truck"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Suppliers</span>
                <span class="text-2xl font-bold text-slate-800">{{ $warehouse->suppliers->count() }}</span>
            </div>
        </div>
    </div>
    
    <!-- Warehouse Meta Information -->
    <div class="mt-6 mb-6 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-slate-100">
            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-info-circle text-indigo-500"></i>
                Warehouse Information
            </h3>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-hashtag text-indigo-400"></i>
                    Warehouse ID
                </p>
                <p class="text-sm font-semibold text-slate-900 mt-1">#{{ $warehouse->id }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-calendar-plus text-indigo-400"></i>
                    Created
                </p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $warehouse->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-calendar-alt text-indigo-400"></i>
                    Updated
                </p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $warehouse->updated_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-clock text-indigo-400"></i>
                    Age
                </p>
                <p class="text-sm font-semibold text-emerald-600 mt-1">{{ $warehouse->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Inventory List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-list text-indigo-500"></i> 
                        Itemized Inventory Manifest
                        <span class="ml-2 text-xs bg-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-full font-medium">
                            {{ $warehouse->products->count() }} Products
                        </span>
                    </h3>
                    <div class="flex gap-2">
                        @can('manage inventory')
                            <a href="{{ route('inventory.transfer.create', ['from_warehouse_id' => $warehouse->id]) }}"
                               class="inline-flex items-center gap-1.5 bg-slate-200 text-slate-700 hover:bg-slate-900 hover:text-white font-medium px-3 py-1.5 rounded-xl text-xs transition-all">
                                <i class="fa-solid fa-arrow-right-arrow-left"></i> Transfer
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                            <tr>
                                <th class="text-left px-6 py-4">Product</th>
                                <th class="text-left px-6 py-4">SKU</th>
                                <th class="text-right px-6 py-4">Price</th>
                                <th class="text-center px-6 py-4">Status</th>
                                <th class="text-right px-6 py-4">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($warehouse->products as $product)
                            <tr class="hover:bg-indigo-50/40 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-emerald-600">
                                            <i class="fa-solid fa-box text-xs"></i>
                                        </div>
                                        <span class="font-semibold text-slate-900">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">
                                    {{ $product->sku ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-slate-600">
                                    PKR {{ number_format($product->sale_price, 0) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->pivot->stock > 20)
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-medium border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Good Stock
                                        </span>
                                    @elseif($product->pivot->stock > 0)
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-full text-xs font-medium border border-rose-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Out of Stock
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
                                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                            <i class="fa-solid fa-boxes-packing text-2xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-500 text-base">This warehouse is empty</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Add products through purchase orders or transfers</p>
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
        
        <!-- Right Column - Supplier List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-slate-100">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-truck text-indigo-500"></i> 
                        Assigned Suppliers
                        <span class="ml-auto text-xs bg-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-full font-medium">
                            {{ $warehouse->suppliers->count() }}
                        </span>
                    </h3>
                </div>
                <div class="p-4 max-h-[400px] overflow-y-auto">
                    @forelse($warehouse->suppliers as $supplier)
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-all duration-200 group">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <i class="fa-solid fa-user-tie text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-slate-900 text-sm">{{ $supplier->name }}</p>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="flex items-center gap-0.5">
                                        <i class="fa-solid fa-envelope text-[10px] text-slate-400"></i>
                                        {{ $supplier->email ?? 'No email' }}
                                    </span>
                                    @if($supplier->phone)
                                        <span class="flex items-center gap-0.5">
                                            <i class="fa-solid fa-phone text-[10px] text-slate-400"></i>
                                            {{ $supplier->phone }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{-- <a href="{{ route('suppliers.show', $supplier->id) }}" 
                               class="text-indigo-400 hover:text-indigo-600 transition-colors opacity-0 group-hover:opacity-100">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a> --}}
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400">
                            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-truck text-2xl text-slate-300"></i>
                            </div>
                            <p class="font-medium text-slate-500 text-sm">No suppliers assigned</p>
                            <p class="text-xs text-slate-400 mt-0.5">Add suppliers to this warehouse</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    /* Custom scrollbar for supplier list */
    .max-h-\[400px\]::-webkit-scrollbar {
        width: 4px;
    }
    .max-h-\[400px\]::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .max-h-\[400px\]::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Hover effects */
    .group {
        transition: all 0.3s ease;
    }
    .group:hover {
        transform: translateX(4px);
    }
    
    .hover\:shadow-md {
        transition: all 0.3s ease;
    }
    .hover\:shadow-md:hover {
        transform: translateY(-2px);
    }
    
    /* Supplier tooltip */
    .group-hover\:visible {
        visibility: visible;
    }
    .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>
@endpush