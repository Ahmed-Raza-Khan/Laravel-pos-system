@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-2 sm:px-6 py-6">
    
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-chart-pie text-slate-700"></i> Control Center Dashboard
            </h1>
            <p class="text-slate-500 mt-1">Real-time enterprise analytics and operations monitoring</p>
        </div>
        <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-xl border border-slate-200/60 text-xs font-semibold text-slate-600">
            <span class="bg-white px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-1.5 text-slate-800">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Operational Live
            </span>
            <span class="px-3 py-1.5">{{ now()->format('d M Y') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Total Sales Revenue</span>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $setting->currency ?? 'PKR' }} {{ number_format($totalSales, 0) }}</h3>
                </div>
                <div class="bg-blue-50 text-blue-600 rounded-2xl p-3.5 group-hover:scale-110 transition-transform duration-200">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-medium text-emerald-600">
                <i class="fa-solid fa-trend-up"></i>
                <span>All-time recorded turnover</span>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Procurement Cost</span>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $setting->currency ?? 'PKR' }} {{ number_format($totalPurchases, 0) }}</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 rounded-2xl p-3.5 group-hover:scale-110 transition-transform duration-200">
                    <i class="fa-solid fa-cart-flatbed-suitcase text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-medium text-slate-400">
                <i class="fa-solid fa-info-circle"></i>
                <span>Inventory stock purchases</span>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Net Balance</span>
                    <h3 class="text-2xl font-bold {{ $netProfitLoss >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $setting->currency ?? 'PKR' }} {{ number_format($netProfitLoss, 0) }}
                    </h3>
                </div>
                <div class="rounded-2xl p-3.5 group-hover:scale-110 transition-transform duration-200 {{ $netProfitLoss >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                    <i class="fa-solid fa-scale-balanced text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-medium {{ $netProfitLoss >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                <i class="fa-solid {{ $netProfitLoss >= 0 ? 'fa-circle-check' : 'fa-circle-exclamation' }}"></i>
                <span>{{ $netProfitLoss >= 0 ? 'Gross Profit Margins Dynamic' : 'Deficit variance noted' }}</span>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Active Catalog</span>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $totalProducts }} <span class="text-xs text-slate-400 font-normal">Products</span></h3>
                </div>
                <div class="bg-indigo-50 text-indigo-600 rounded-2xl p-3.5 group-hover:scale-110 transition-transform duration-200">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-3 text-xs text-slate-500 font-medium">
                <span><i class="fa-solid fa-users text-purple-500"></i> {{ $totalCustomers }} Clients</span>
                <span><i class="fa-solid fa-truck-field text-pink-500"></i> {{ $totalSuppliers }} Vendors</span>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-slate-900 text-white p-5 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <div class="bg-slate-800 p-3 rounded-xl border border-slate-700 text-amber-400">
                    <i class="fa-solid fa-ban text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Voided Orders</p>
                    <h4 class="text-xl font-bold text-white mt-0.5">{{ $voidSalesCount }} Sales Void</h4>
                </div>
            </div>
            <span class="text-xs bg-red-500/20 text-red-400 font-semibold px-2.5 py-1 rounded-lg">Canceled Logs</span>
        </div>

        <div class="bg-white border border-slate-100 p-5 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <div class="bg-lime-50 p-3 rounded-xl text-lime-600">
                    <i class="fa-solid fa-arrow-right-arrow-left text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Stock Distribution</p>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">Warehouse System</h4>
                </div>
            </div>
            <a href="{{ route('inventory.transfer.create') }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-3 py-1.5 rounded-lg transition-colors">
                Open Engine
            </a>
        </div>

        <div class="bg-white border border-slate-100 p-5 rounded-2xl flex items-center justify-between shadow-sm sm:col-span-2 lg:col-span-1">
            <div class="flex items-center gap-4">
                <div class="bg-purple-50 p-3 rounded-xl text-purple-600">
                    <i class="fa-solid fa-sliders text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Global Configuration</p>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">Settings System</h4>
                </div>
            </div>
            <a href="{{ route('settings.index') }}" class="text-xs text-purple-600 hover:text-purple-700 font-bold flex items-center gap-1">
                Manage <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        <div class="bg-white rounded-3xl shadow-sm p-6 border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-chart-bar text-blue-600"></i> Monthly Sales Run
                </h3>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">Revenue Flow</span>
            </div>
            <div class="relative h-[280px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm p-6 border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-amber-500"></i> Stock Purchase Velocity
                </h3>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Expense Monitor</span>
            </div>
            <div class="relative h-[280px]">
                <canvas id="purchaseChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white rounded-3xl shadow-sm p-6 border border-slate-100 lg:col-span-2">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-emerald-600"></i> Latest Sales Ledger
                </h3>
                <a href="{{ route('sales.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">View All Bookings</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wider text-left">
                            <th class="pb-3">Invoice No</th>
                            <th class="pb-3">Customer Account</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Grand Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($recentSales as $sale)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <td class="py-3.5 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                    {{ $sale->invoice_no }}
                                </td>
                                <td class="py-3.5 text-slate-600 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-xs font-bold uppercase">
                                        {{ substr($sale->customer?->name ?? 'W', 0, 1) }}
                                    </div>
                                    {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                                </td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $sale->status === 'void' ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $sale->status === 'void' ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                                        {{ strtoupper($sale->status ?? 'paid') }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-right font-bold text-slate-900">
                                    {{ $setting->currency ?? 'PKR' }} {{ number_format($sale->grand_total, 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400 text-xs">
                                    <i class="fa-solid fa-folder-open block text-2xl mb-2 text-slate-300"></i> No sales registered yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8 lg:col-span-1">
            
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2 mb-5">
                    <i class="fa-solid fa-crown text-amber-500"></i> High Velocity Items
                </h3>
                <div class="divide-y divide-slate-50">
                    @forelse ($topProducts as $index => $item)
                        <div class="py-3 flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center border border-slate-200/50">
                                    #{{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm group-hover:text-indigo-600 transition-colors">{{ $item->product?->name ?? 'Unknown Item' }}</p>
                                    <p class="text-xs text-slate-400">SKU: {{ $item->product?->sku ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-extrabold px-2.5 py-1 rounded-xl border border-indigo-100/40">
                                {{ $item->total_qty }} Sold
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-400 text-xs text-center py-6">No volume trends cataloged.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm p-6 border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2 mb-5">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Stock Deficit Triggers
                </h3>
                <div class="space-y-3">
                    @forelse($lowStockProducts as $product)
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-3.5 flex items-center justify-between hover:bg-rose-50/20 transition-colors">
                            <div class="min-w-0">
                                <h4 class="font-bold text-slate-900 text-sm truncate">{{ $product->name }}</h4>
                                <p class="text-xs text-slate-400 truncate">SKU: {{ $product->sku }}</p>
                            </div>
                            <span class="shrink-0 font-extrabold text-xs bg-rose-50 text-rose-600 px-3 py-1.5 rounded-xl border border-rose-100">
                                {{ $product->total_stock ?? 0 }} Left
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 bg-emerald-50/30 border border-emerald-100/50 rounded-2xl">
                            <i class="fa-solid fa-circle-check text-xl text-emerald-500 mb-1 block"></i>
                            <p class="text-emerald-800 font-medium text-xs">All warehouses perfectly stocked!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Shared Chart Styling Setup Configuration
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { family: 'Inter, sans-serif', size: 11 }, color: '#94a3b8' } },
                y: { grid: { borderDash: [5, 5], color: '#f1f5f9' }, ticks: { font: { family: 'Inter, sans-serif', size: 11 }, color: '#94a3b8' } }
            }
        };

        // Monthly Sales Chart Init
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    data: {!! json_encode($salesData) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 8,
                    maxBarThickness: 32
                }]
            },
            options: chartOptions
        });

        // Monthly Purchase Curve Init
        const purchaseCtx = document.getElementById('purchaseChart').getContext('2d');
        new Chart(purchaseCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    data: {!! json_encode($purchaseData) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#f59e0b'
                }]
            },
            options: chartOptions
        });
    });
</script>
@endsection