@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-4 py-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Purchase Report</h1>
        <p class="text-gray-500 mt-1">Supplier purchases and stock received</p>
    </div>

    @include('reports.partials.nav')

    <form method="GET" class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 mb-8 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" class="rounded-2xl border-slate-200 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" class="rounded-2xl border-slate-200 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-1">Supplier</label>
            <select name="supplier_id" class="rounded-2xl border-slate-200 shadow-sm min-w-[180px]">
                <option value="">All Suppliers</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold">Apply</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl shadow-lg p-6 border border-orange-200">
            <p class="text-orange-600 text-sm font-semibold uppercase">Total Purchased Stock</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($total_purchased_stock) }} units</p>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-6 border border-blue-200">
            <p class="text-blue-600 text-sm font-semibold uppercase">Total Purchase Amount</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $setting->currency ?? 'PKR' }} {{ number_format($total_purchase_amount, 0) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-6 py-4 font-semibold">Invoice</th>
                        <th class="px-6 py-4 font-semibold">Supplier</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Items Qty</th>
                        <th class="px-6 py-4 font-semibold text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($purchases as $purchase)
                        <tr class="hover:bg-orange-50 transition">
                            <td class="px-6 py-4 font-medium text-indigo-600">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="hover:underline">{{ $purchase->invoice_no }}</a>
                            </td>
                            <td class="px-6 py-4">{{ $purchase->supplier?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $purchase->purchase_date?->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $purchase->items->sum('quantity') }}</td>
                            <td class="px-6 py-4 text-right font-bold">{{ $setting->currency ?? 'PKR' }} {{ number_format($purchase->total_amount, 0) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No purchases found for selected filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
