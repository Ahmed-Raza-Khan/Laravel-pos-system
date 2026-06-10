@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-2 sm:px-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-boxes-stacked text-slate-700"></i> Inventory Management
                </h2>
                <p class="text-slate-500 mt-1">Adjust stock levels, execute transfers, and view complete inventory history.</p>
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('inventory.transfer.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-medium px-5 py-3 rounded-xl shadow-sm transition-all duration-200 group text-sm w-full sm:w-auto transform active:scale-95">
                    <i class="fa-solid fa-arrow-right-arrow-left transition-transform group-hover:translate-x-0.5"></i> Transfer Stock
                </a>
                
                <a href="{{ route('inventory.history') }}"
                    class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-medium px-5 py-3 rounded-xl shadow-sm border border-slate-200 transition-all duration-200 text-sm w-full sm:w-auto">
                    <i class="fa-solid fa-history text-slate-400"></i> History
                </a>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form method="GET" action="{{ route('inventory.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-5">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Search Product</label>
                        <select id="productSearch" name="product_id" class="w-full">
                            <option value="">Select Product</option>
                            @foreach ($allProducts as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Filter By Warehouse</label>
                        <select name="warehouse_id" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:border-slate-400 focus:ring-0" required>
                            <option value="">Select Warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="flex-1 bg-lime-600 hover:bg-lime-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm shadow-sm transition-colors">
                            <i class="fa-solid fa-magnifying-glass mr-1 text-xs"></i> Search
                        </button>
                        <a href="{{ route('inventory.index') }}"
                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl text-sm transition-colors flex items-center justify-center border border-slate-200/60">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">Product Name</th>
                            <th class="px-6 py-4 text-left">Current Stock Status</th>
                            <th class="px-6 py-4 text-left">Manual Adjustment</th>
                            <th class="px-6 py-4 text-center">Quick Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($products as $product)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $currentWarehouseId = request('warehouse_id');
                                        $warehouseStock = 0;

                                        if ($currentWarehouseId) {
                                            $matchedWarehouse = $product->warehouses->first();
                                            
                                            if ($matchedWarehouse && $matchedWarehouse->id == $currentWarehouseId) {
                                                $warehouseStock = $matchedWarehouse->pivot->stock ?? 0;
                                            } else {
                                                $warehouseStock = 0;
                                            }
                                        } else {
                                            $warehouseStock = $product->total_stock ?? 0;
                                        }
                                    @endphp

                                    @if ($warehouseStock <= 5)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                            {{ $warehouseStock }} Low Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $warehouseStock }} Units Available
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('inventory.adjust', $product->id) }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="warehouse_id" value="{{ request('warehouse_id') }}">
                                        
                                        <select name="type" class="border border-slate-200 rounded-xl px-2.5 py-1.5 text-xs bg-white focus:border-slate-400 focus:ring-0">
                                            <option value="add">➕ Add</option>
                                            <option value="subtract">➖ Sub</option>
                                        </select>

                                        <input type="number" name="quantity" placeholder="Qty" required min="1" 
                                            class="border border-slate-200 rounded-xl px-3 py-1.5 w-20 text-xs focus:border-slate-400 focus:ring-0">
                                        
                                        <input type="text" name="notes" placeholder="Reason/Notes..." 
                                            class="border border-slate-200 rounded-xl px-3 py-1.5 text-xs w-44 md:w-56 focus:border-slate-400 focus:ring-0">
                                        
                                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-medium px-3 py-1.5 rounded-xl text-xs transition-colors shadow-sm">
                                            Apply
                                        </button>
                                    </form>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('inventory.transfer.create', [
                                        'from_warehouse_id' => request('warehouse_id'),
                                        'product_id' => $product->id
                                    ]) }}" 
                                       class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-xl border transition-all {{ request('warehouse_id') ? 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-600 hover:text-white' : 'bg-slate-50 text-slate-400 border-slate-200 cursor-not-allowed pointer-events-none' }}"
                                       title="{{ request('warehouse_id') ? 'Transfer this product' : 'Select a warehouse filter first to transfer' }}">
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i> Transfer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <i class="fa-solid fa-boxes-pure text-3xl text-slate-300"></i>
                                        <div>
                                            <p class="font-medium text-slate-500 text-base">No products match the filter</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Please update your filters or select a warehouse location.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#productSearch').select2({
                    placeholder: 'Search Product...',
                    allowClear: true,
                    width: '100%'
                });

                $('#productSearch').on('change', function() {
                    if($(this).val()) {
                        this.form.submit();
                    }
                });
            });
        </script>
    @endpush
@endsection