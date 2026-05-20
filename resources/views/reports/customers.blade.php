@extends('layouts.app')

@section('content')
<section class="w-full mx-auto px-4 py-6">

    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Customer Report</h1>
        <p class="text-gray-500 mt-1">Purchases, dues, and top customers</p>
    </section>

    @include('reports.partials.nav')

    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <section class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-3xl shadow-lg p-6 border border-purple-200">
            <p class="text-purple-600 text-sm font-semibold uppercase">Total Customers</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $summary['total_customers'] }}</p>
        </section>
        <section class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-6 border border-blue-200">
            <p class="text-blue-600 text-sm font-semibold uppercase">Total Purchases</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($summary['total_sales_amount'], 0) }}</p>
        </section>
        <section class="bg-gradient-to-br from-red-50 to-red-100 rounded-3xl shadow-lg p-6 border border-red-200">
            <p class="text-red-600 text-sm font-semibold uppercase">Total Due Amount</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($summary['total_due_amount'], 0) }}</p>
        </section>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <section class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Top Customers</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 font-semibold text-slate-600">Customer</th>
                        <th class="text-right py-3 font-semibold text-slate-600">Orders</th>
                        <th class="text-right py-3 font-semibold text-slate-600">Total</th>
                        <th class="text-right py-3 font-semibold text-slate-600">Due</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($top_customers as $customer)
                        <tr>
                            <td class="py-3 font-medium">{{ $customer->name }}</td>
                            <td class="py-3 text-right">{{ $customer->sales_count }}</td>
                            <td class="py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($customer->total_purchases ?? 0, 0) }}</td>
                            <td class="py-3 text-right text-red-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($customer->total_due ?? 0, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Recent Orders</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 font-semibold text-slate-600">Invoice</th>
                        <th class="text-left py-3 font-semibold text-slate-600">Customer</th>
                        <th class="text-right py-3 font-semibold text-slate-600">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recent_orders as $sale)
                        <tr>
                            <td class="py-3">
                                <a href="{{ route('sales.show', $sale->id) }}" class="text-indigo-600 hover:underline">{{ $sale->invoice_no }}</a>
                            </td>
                            <td class="py-3">{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                            <td class="py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->grand_total, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>

    <section class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <section class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">All Customers</h2>
        </section>
        <section class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-6 py-4 font-semibold">Name</th>
                        <th class="px-6 py-4 font-semibold">Phone</th>
                        <th class="px-6 py-4 font-semibold text-right">Orders</th>
                        <th class="px-6 py-4 font-semibold text-right">Total Purchases</th>
                        <th class="px-6 py-4 font-semibold text-right">Due</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($customers as $customer)
                        <tr class="hover:bg-purple-50">
                            <td class="px-6 py-4 font-medium">{{ $customer->name }}</td>
                            <td class="px-6 py-4">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">{{ $customer->sales_count }}</td>
                            <td class="px-6 py-4 text-right">{{ $setting->currency ?? 'PKR' }} {{ number_format($customer->total_purchases ?? 0, 0) }}</td>
                            <td class="px-6 py-4 text-right text-red-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($customer->total_due ?? 0, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>
</section>
@endsection
