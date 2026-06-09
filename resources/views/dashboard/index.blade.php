@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard
            </h1>

            <p class="text-gray-500 mt-1">
                POS analytics overview
            </p>
        </div>

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Total Sales Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-8 border border-blue-200 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-semibold uppercase tracking-wide">Total Sales</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($totalSales, 0) }}</p>
                        <p class="text-blue-700 text-sm mt-3 font-medium">All-time sales revenue</p>
                    </div>
                    <div class="bg-blue-500 rounded-full p-4 text-white opacity-20">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Total Purchases Card -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl shadow-lg p-8 border border-orange-200 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Total Purchases</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($totalPurchases, 0) }}</p>
                        <p class="text-orange-700 text-sm mt-3 font-medium">Total spending on inventory</p>
                    </div>
                    <div class="bg-orange-500 rounded-full p-4 text-white opacity-20">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl shadow-lg p-8 border border-green-200 hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-semibold uppercase tracking-wide">Total Products</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $totalProducts }}</p>
                        <p class="text-green-700 text-sm mt-3 font-medium">Active SKUs in inventory</p>
                    </div>
                    <div class="bg-green-500 rounded-full p-4 text-white opacity-20">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM4 15a2 2 0 100 4h12a2 2 0 100-4H4z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Customers & Suppliers Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <!-- Customers Card -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-3xl shadow-lg p-6 border border-purple-200 hover:shadow-xl transition">
                    <p class="text-purple-600 text-sm font-semibold uppercase tracking-wide">Customers</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalCustomers }}</p>
                    <p class="text-purple-700 text-sm mt-2 font-medium">Active customers</p>
                </div>

                <!-- Suppliers Card -->
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-3xl shadow-lg p-6 border border-pink-200 hover:shadow-xl transition">
                    <p class="text-pink-600 text-sm font-semibold uppercase tracking-wide">Suppliers</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalSuppliers }}</p>
                    <p class="text-pink-700 text-sm mt-2 font-medium">Active suppliers</p>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            {{-- SALES CHART --}}
            <div class="bg-gradient-to-br from-blue-50 to-white rounded-3xl shadow-lg p-8 border border-blue-100">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    Monthly Sales
                </h2>
                <canvas id="salesChart"></canvas>
            </div>

            {{-- PURCHASE CHART --}}
            <div class="bg-gradient-to-br from-orange-50 to-white rounded-3xl shadow-lg p-8 border border-orange-100">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path></svg>
                    Monthly Purchases
                </h2>
                <canvas id="purchaseChart"></canvas>
            </div>
        </div>

        {{-- RECENT SALES & LOW STOCK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            {{-- RECENT SALES --}}
            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-3xl shadow-lg p-8 border border-emerald-100">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM4 15a2 2 0 100 4h12a2 2 0 100-4H4z"></path></svg>
                    Recent Sales
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-emerald-200">
                                <th class="text-left py-3 text-emerald-700 font-semibold">Invoice</th>
                                <th class="text-left py-3 text-emerald-700 font-semibold">Customer</th>
                                <th class="text-right py-3 text-emerald-700 font-semibold">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($recentSales as $sale)
                                <tr class="hover:bg-emerald-50 transition">
                                    <td class="py-3 text-slate-700 font-medium">{{ $sale->invoice_no }}</td>
                                    <td class="py-3 text-slate-600">{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                                    <td class="py-3 text-right text-emerald-600 font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->grand_total, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- LOW STOCK --}}
            <div class="bg-gradient-to-br from-red-50 to-white rounded-3xl shadow-lg p-8 border border-red-100">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Low Stock Alerts
                </h2>
                <div class="space-y-3">
                    @forelse($lowStockProducts as $product)
                        <div class="bg-white border-l-4 border-red-500 rounded-lg p-4 flex items-center justify-between hover:shadow-md transition">
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ $product->name }}</h3>
                                <p class="text-sm text-slate-500">SKU: {{ $product->sku }}</p>
                            </div>
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold">
                                {{ $product->total_stock }} Left
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-500 py-4 text-center">✓ All products well stocked!</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- TOP PRODUCTS --}}
        <div class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl shadow-lg p-8 border border-indigo-100">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                Top Selling Products
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-indigo-200">
                            <th class="text-left py-3 text-indigo-700 font-semibold">Product</th>
                            <th class="text-right py-3 text-indigo-700 font-semibold">Sold Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($topProducts as $item)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="py-3 text-slate-700 font-medium">{{ $item->product?->name }}</td>
                                <td class="py-3 text-right">
                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-bold">
                                        {{ $item->total_qty }}
                                    </span>
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
