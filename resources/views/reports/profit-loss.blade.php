@extends('layouts.app')

@section('content')
<section class="w-full mx-auto px-4 py-6">

    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Profit / Loss Report</h1>
        <p class="text-gray-500 mt-1">Revenue minus purchase cost on sold items</p>
    </section>

    @include('reports.partials.nav')

    <form method="GET" class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 mb-8 flex flex-wrap gap-4 items-end">
        <section>
            <label class="block text-sm font-semibold text-slate-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" class="rounded-2xl border-slate-200 shadow-sm">
        </section>
        <section>
            <label class="block text-sm font-semibold text-slate-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" class="rounded-2xl border-slate-200 shadow-sm">
        </section>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl text-sm font-semibold">Apply</button>
    </form>

    <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <section class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-6 border border-blue-200">
            <p class="text-blue-600 text-sm font-semibold uppercase">Revenue</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">PKR {{ number_format($revenue, 0) }}</p>
        </section>
        <section class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl shadow-lg p-6 border border-orange-200">
            <p class="text-orange-600 text-sm font-semibold uppercase">Purchase Cost</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">PKR {{ number_format($cost, 0) }}</p>
        </section>
        <section class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-3xl shadow-lg p-6 border border-emerald-200">
            <p class="text-emerald-600 text-sm font-semibold uppercase">Profit</p>
            <p class="text-2xl font-bold {{ $profit >= 0 ? 'text-emerald-800' : 'text-red-700' }} mt-2">PKR {{ number_format($profit, 0) }}</p>
        </section>
        <section class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl shadow-lg p-6 border border-indigo-200">
            <p class="text-indigo-600 text-sm font-semibold uppercase">Sold Qty</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($sold_qty) }}</p>
        </section>
    </section>

    <section class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <section class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Product Profit Breakdown</h2>
            <p class="text-sm text-slate-500 mt-1">profit = sale revenue − (quantity × purchase_price)</p>
        </section>
        <section class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold text-right">Sold Qty</th>
                        <th class="px-6 py-4 font-semibold text-right">Revenue</th>
                        <th class="px-6 py-4 font-semibold text-right">Cost</th>
                        <th class="px-6 py-4 font-semibold text-right">Profit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($product_breakdown as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium">{{ $row->product?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-right">{{ $row->sold_qty }}</td>
                            <td class="px-6 py-4 text-right">PKR {{ number_format($row->revenue, 0) }}</td>
                            <td class="px-6 py-4 text-right">PKR {{ number_format($row->cost, 0) }}</td>
                            <td class="px-6 py-4 text-right font-bold {{ $row->profit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                PKR {{ number_format($row->profit, 0) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No sales data for selected period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </section>
</section>
@endsection
