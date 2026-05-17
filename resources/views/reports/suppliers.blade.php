@extends('layouts.app')

@section('content')
<section class="w-full mx-auto px-4 py-6">

    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Supplier Report</h1>
        <p class="text-gray-500 mt-1">Purchase history and supplied products</p>
    </section>

    @include('reports.partials.nav')

    <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <section class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-3xl shadow-lg p-6 border border-pink-200">
            <p class="text-pink-600 text-sm font-semibold uppercase">Total Suppliers</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $total_suppliers }}</p>
        </section>
        <section class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl shadow-lg p-6 border border-orange-200">
            <p class="text-orange-600 text-sm font-semibold uppercase">Total Purchase Amount</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">PKR {{ number_format($total_purchase_amount, 0) }}</p>
        </section>
    </section>

    <section class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100 mb-8">
        <section class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Suppliers Summary</h2>
        </section>
        <section class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-6 py-4 font-semibold">Supplier</th>
                        <th class="px-6 py-4 font-semibold">Company</th>
                        <th class="px-6 py-4 font-semibold text-right">Purchases</th>
                        <th class="px-6 py-4 font-semibold text-right">Products Supplied</th>
                        <th class="px-6 py-4 font-semibold text-right">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($suppliers as $supplier)
                        <tr class="hover:bg-pink-50">
                            <td class="px-6 py-4 font-medium">{{ $supplier->name }}</td>
                            <td class="px-6 py-4">{{ $supplier->company ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">{{ $supplier->purchases_count }}</td>
                            <td class="px-6 py-4 text-right">{{ number_format($supplier->total_supplied_products) }}</td>
                            <td class="px-6 py-4 text-right font-bold">PKR {{ number_format($supplier->total_purchase_amount ?? 0, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>

    <section class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <section class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Recent Purchase History</h2>
        </section>
        <section class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-6 py-4 font-semibold">Invoice</th>
                        <th class="px-6 py-4 font-semibold">Supplier</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold text-right">Items</th>
                        <th class="px-6 py-4 font-semibold text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($purchase_history as $purchase)
                        <tr class="hover:bg-orange-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="text-indigo-600 font-medium hover:underline">{{ $purchase->invoice_no }}</a>
                            </td>
                            <td class="px-6 py-4">{{ $purchase->supplier?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $purchase->purchase_date?->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">{{ $purchase->items->sum('quantity') }}</td>
                            <td class="px-6 py-4 text-right font-bold">PKR {{ number_format($purchase->total_amount, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>
</section>
@endsection
