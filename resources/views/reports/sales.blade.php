@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-4 py-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Sales Reports</h1>
        <p class="text-gray-500 mt-1">Daily and monthly sales analytics</p>
    </div>

    @include('reports.partials.nav')

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-3xl p-4 mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex gap-2 mb-8">
        <a href="{{ route('reports.sales', ['tab' => 'daily']) }}"
           class="px-4 py-2 rounded-2xl text-sm font-semibold {{ $tab === 'daily' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
            Daily Sales
        </a>
        <a href="{{ route('reports.sales', ['tab' => 'monthly']) }}"
           class="px-4 py-2 rounded-2xl text-sm font-semibold {{ $tab === 'monthly' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
            Monthly Sales
        </a>
    </div>

    @if ($tab === 'daily' && $daily)
        <form method="GET" class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 mb-8 flex flex-wrap gap-4 items-end">
            <input type="hidden" name="tab" value="daily">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Date</label>
                <input type="date" name="date" value="{{ request('date', $daily['date']) }}"
                       class="rounded-2xl border-slate-200 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">End Date (optional)</label>
                <input type="date" name="end_date" value="{{ request('end_date', $daily['end_date']) }}"
                       class="rounded-2xl border-slate-200 shadow-sm">
            </div>
            <button type="submit" name="today" value="1"
                    class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold">
                Today
            </button>
            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-2xl text-sm font-semibold">
                Apply Filter
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-6 border border-blue-200">
                <p class="text-blue-600 text-sm font-semibold uppercase">Total Sales</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($daily['total_sales'], 0) }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-3xl shadow-lg p-6 border border-emerald-200">
                <p class="text-emerald-600 text-sm font-semibold uppercase">Invoices</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $daily['invoice_count'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl shadow-lg p-6 border border-indigo-200">
                <p class="text-indigo-600 text-sm font-semibold uppercase">Profit</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($daily['profit'], 0) }}</p>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-3xl shadow-lg p-6 border border-amber-200">
                <p class="text-amber-600 text-sm font-semibold uppercase">Taxes</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($daily['taxes'], 0) }}</p>
            </div>
            <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-3xl shadow-lg p-6 border border-rose-200">
                <p class="text-rose-600 text-sm font-semibold uppercase">Discounts</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($daily['discounts'], 0) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Payment Methods</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 font-semibold text-slate-600">Method</th>
                            <th class="text-right py-3 font-semibold text-slate-600">Count</th>
                            <th class="text-right py-3 font-semibold text-slate-600">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($daily['payment_methods'] as $method)
                            <tr>
                                <td class="py-3 capitalize">{{ str_replace('_', ' ', $method->payment_method) }}</td>
                                <td class="py-3 text-right">{{ $method->count }}</td>
                                <td class="py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($method->total, 0) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-4 text-slate-500 text-center">No sales for this period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Invoices</h2>
                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 font-semibold text-slate-600">Invoice</th>
                                <th class="text-left py-3 font-semibold text-slate-600">Customer</th>
                                <th class="text-right py-3 font-semibold text-slate-600">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($daily['invoices'] as $sale)
                                <tr>
                                    <td class="py-3">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="text-indigo-600 font-medium hover:underline">{{ $sale->invoice_no }}</a>
                                    </td>
                                    <td class="py-3">{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                                    <td class="py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->grand_total, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if ($tab === 'monthly' && $monthly)
        <form method="GET" class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 mb-8 flex flex-wrap gap-4 items-end">
            <input type="hidden" name="tab" value="monthly">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Year</label>
                <select name="year" class="rounded-2xl border-slate-200 shadow-sm">
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Month</label>
                <select name="month" class="rounded-2xl border-slate-200 shadow-sm">
                    <option value="" {{ empty(request('month')) ? 'selected' : '' }}>All Months</option>
                    @foreach(range(1, 12) as $monthNumber)
                        <option value="{{ $monthNumber }}" {{ request('month') == $monthNumber ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($monthNumber)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold">
                Apply
            </button>
        </form>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-8 border border-blue-200 mb-8">
            <p class="text-blue-600 text-sm font-semibold uppercase">Monthly Revenue ({{ $monthly['year'] }})</p>
            <p class="text-4xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($monthly['monthly_revenue'], 0) }}</p>
            @if($monthly['selected_month'])
                <p class="text-slate-600 mt-2">Selected month: <span class="font-semibold">{{ $monthly['selected_month'] }}</span></p>
                <p class="text-slate-600">Revenue: <span class="font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($monthly['selected_month_total'], 0) }}</span></p>
                <p class="text-slate-600">Invoices: <span class="font-semibold">{{ $monthly['selected_month_invoices'] }}</span></p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Month-wise Sales</h2>
                <canvas id="monthlySalesChart" height="200"></canvas>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Best Selling Products</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 font-semibold text-slate-600">Product</th>
                            <th class="text-right py-3 font-semibold text-slate-600">Qty</th>
                            <th class="text-right py-3 font-semibold text-slate-600">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($monthly['best_selling_products'] as $item)
                            <tr>
                                <td class="py-3">{{ $item->product?->name ?? 'N/A' }}</td>
                                <td class="py-3 text-right">{{ $item->total_qty }}</td>
                                <td class="py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($item->revenue, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('monthlySalesChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthly['month_names']->pluck('label')->values()) !!},
                    datasets: [{
                        label: 'Sales ({{ $setting->currency ?? 'PKR' }})',
                        data: {!! json_encode($monthly['month_names']->pluck('total')->values()) !!},
                        backgroundColor: 'rgba(99, 102, 241, 0.6)',
                        borderColor: 'rgb(99, 102, 241)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    @endif
</div>
@endsection
