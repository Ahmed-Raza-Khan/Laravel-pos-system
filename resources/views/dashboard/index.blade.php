@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard
            </h1>

            <p class="text-gray-500 mt-1">
                POS analytics overview
            </p>

        </div>

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-gray-500 text-sm">
                    Total Sales
                </h3>

                <p class="text-2xl font-bold mt-2">
                    PKR {{ number_format($totalSales, 2) }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-gray-500 text-sm">
                    Total Purchases
                </h3>

                <p class="text-2xl font-bold mt-2">
                    PKR {{ number_format($totalPurchases, 2) }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-gray-500 text-sm">
                    Products
                </h3>

                <p class="text-2xl font-bold mt-2">
                    {{ $totalProducts }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-gray-500 text-sm">
                    Customers
                </h3>

                <p class="text-2xl font-bold mt-2">
                    {{ $totalCustomers }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-gray-500 text-sm">
                    Suppliers
                </h3>

                <p class="text-2xl font-bold mt-2">
                    {{ $totalSuppliers }}
                </p>
            </div>

        </div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            {{-- SALES CHART --}}
            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-lg font-semibold mb-4">
                    Monthly Sales
                </h2>

                <canvas id="salesChart"></canvas>

            </div>

            {{-- PURCHASE CHART --}}
            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-lg font-semibold mb-4">
                    Monthly Purchases
                </h2>

                <canvas id="purchaseChart"></canvas>

            </div>

        </div>

        {{-- TABLES --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- RECENT SALES --}}
            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-lg font-semibold">
                        Recent Sales
                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead>

                            <tr class="border-b">

                                <th class="text-left py-2">
                                    Invoice
                                </th>

                                <th class="text-left py-2">
                                    Customer
                                </th>

                                <th class="text-left py-2">
                                    Total
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($recentSales as $sale)
                                <tr class="border-b">

                                    <td class="py-3">
                                        {{ $sale->invoice_no }}
                                    </td>

                                    <td class="py-3">
                                        {{ $sale->customer?->name ?? 'Walk-in' }}
                                    </td>

                                    <td class="py-3">
                                        PKR {{ number_format($sale->grand_total, 2) }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- LOW STOCK --}}
            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-lg font-semibold mb-4">
                    Low Stock Alerts
                </h2>

                <div class="space-y-3">

                    @forelse($lowStockProducts as $product)
                        <div class="border rounded-xl p-4 flex items-center justify-between">

                            <div>

                                <h3 class="font-medium">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    SKU: {{ $product->sku }}
                                </p>

                            </div>

                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $product->stock }} Left
                            </span>

                        </div>

                    @empty

                        <p class="text-gray-500">
                            No low stock products.
                        </p>
                    @endforelse

                </div>

            </div>

        </div>

        {{-- TOP PRODUCTS --}}
        <div class="bg-white rounded-2xl shadow p-6 mt-8">

            <h2 class="text-lg font-semibold mb-4">
                Top Selling Products
            </h2>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-2">
                                Product
                            </th>

                            <th class="text-left py-2">
                                Sold Qty
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($topProducts as $item)
                            <tr class="border-b">

                                <td class="py-3">
                                    {{ $item->product?->name }}
                                </td>

                                <td class="py-3">
                                    {{ $item->total_qty }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesCtx = document
            .getElementById('salesChart');

        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlySales->keys()) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($monthlySales->values()) !!},
                }]
            }
        });
        const purchaseCtx = document
            .getElementById('purchaseChart');
        new Chart(purchaseCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyPurchases->keys()) !!},
                datasets: [{
                    label: 'Purchases',
                    data: {!! json_encode($monthlyPurchases->values()) !!},
                }]
            }
        });
    </script>
@endsection
