@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-1 py-1">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Inventory Management</h2>
                <p class="text-slate-500 mt-1">Adjust stock levels and view complete inventory history</p>
            </div>
            <a href="{{ route('inventory.history') }}"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl">
                Inventory History
            </a>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form method="GET" action="{{ route('inventory.index') }}">
                <div class="flex flex-wrap gap-3">
                    <div class="w-full md:w-96">
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
                    <div class="w-full md:w-64">
                        <select name="warehouse_id" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                            <option value="">Select Warehouse</option>

                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-lime-600 hover:bg-lime-700 text-white px-5 py-2 rounded-lg">
                        Search
                    </button>
                    <a href="{{ route('inventory.index') }}"
                        class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-lg">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-white text-black">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">
                                Product
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                Adjust Stock
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @foreach ($products as $product)
                            <tr class="hover:bg-lime-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $currentWarehouseId = request('warehouse_id');
                                        $warehouseStock = 0;

                                        if ($currentWarehouseId) {
                                            // Agar database relation collection mein entry match karti hai toh wahan se stock uthao
                                            $matchedWarehouse = $product->warehouses->first();
                                            
                                            // Agar filter requested warehouse dynamic match ho jaye toh pivot stock warna strict 0
                                            if ($matchedWarehouse && $matchedWarehouse->id == $currentWarehouseId) {
                                                $warehouseStock = $matchedWarehouse->pivot->stock ?? 0;
                                            } else {
                                                $warehouseStock = 0;
                                            }
                                        } else {
                                            // Agar koi filter nahi laga, toh overall system ka total combined stock show karein
                                            $warehouseStock = $product->total_stock ?? 0;
                                        }
                                    @endphp

                                    @if ($warehouseStock <= 5)
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-700">
                                            {{ $warehouseStock }} Left
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-bold text-emerald-700">
                                            {{ $warehouseStock }} Units
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('inventory.adjust', $product->id) }}" class="flex flex-wrap gap-2">
                                        @csrf

                                        <input type="hidden" name="warehouse_id" value="{{ request('warehouse_id') }}">
                                        <select name="type" class="border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                            <option value="add">Add</option>
                                            <option value="subtract">Subtract</option>
                                        </select>

                                        <input type="number" name="quantity" placeholder="Qty" required class="border border-slate-200 rounded-lg px-3 py-2 w-20 text-sm">
                                        <input type="text" name="notes" placeholder="Notes" class="border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                        <button type="submit" class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded-lg text-sm">
                                            ✓ Save
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
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
                    this.form.submit();
                });
            });
        </script>
    @endpush
@endsection
