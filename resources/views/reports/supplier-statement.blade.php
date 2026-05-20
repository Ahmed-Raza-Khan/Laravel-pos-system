@extends('layouts.app')

@section('content')
<section class="mb-8">
    @include('reports.partials.nav')
    <h1 class="text-3xl font-bold mt-6">Supplier Statement</h1>
    <p class="text-slate-500">{{ $supplier->name }} · {{ $supplier->company }}</p>
</section>

<section class="grid md:grid-cols-4 gap-4 mb-8">
    <section class="rounded-2xl bg-white border p-4"><p class="text-xs text-slate-500 uppercase">Purchases</p><p class="text-2xl font-bold">{{ $totals['count'] }}</p></section>
    <section class="rounded-2xl bg-white border p-4"><p class="text-xs text-slate-500 uppercase">Approved Total</p><p class="text-2xl font-bold text-emerald-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($totals['approved'], 0) }}</p></section>
    <section class="rounded-2xl bg-white border p-4"><p class="text-xs text-slate-500 uppercase">Pending Total</p><p class="text-2xl font-bold text-amber-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($totals['pending'], 0) }}</p></section>
    <section class="rounded-2xl bg-white border p-4"><p class="text-xs text-slate-500 uppercase">Units Received</p><p class="text-2xl font-bold">{{ number_format($totals['items']) }}</p></section>
</section>

<section class="bg-white rounded-3xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-6 py-3 font-semibold">Invoice</th>
                <th class="px-6 py-3 font-semibold">Date</th>
                <th class="px-6 py-3 font-semibold">Status</th>
                <th class="px-6 py-3 font-semibold text-right">Qty</th>
                <th class="px-6 py-3 font-semibold text-right">Amount</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($purchases as $purchase)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3"><a href="{{ route('purchases.show', $purchase->id) }}" class="text-indigo-600 font-medium">{{ $purchase->invoice_no }}</a></td>
                    <td class="px-6 py-3">{{ $purchase->purchase_date?->format('d M Y') }}</td>
                    <td class="px-6 py-3 capitalize">{{ $purchase->status }}</td>
                    <td class="px-6 py-3 text-right">{{ $purchase->items->sum('quantity') }}</td>
                    <td class="px-6 py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($purchase->total_amount, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
