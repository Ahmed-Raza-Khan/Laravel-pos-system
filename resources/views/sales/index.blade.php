@extends('layouts.app')

@section('content')
<section class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <section>
        <h2 class="text-3xl font-bold text-slate-900">Sales</h2>
        <p class="text-slate-500 mt-1">Invoices, dues, voids, and payment history</p>
    </section>
    <a href="{{ route('sales.create') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl">New Sale</a>
</section>

@include('partials.index-toolbar', ['placeholder' => 'Search invoice, customer...'])

<section class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                @include('partials.sortable-th', ['field' => 'id', 'label' => '#'])
                @include('partials.sortable-th', ['field' => 'invoice_no', 'label' => 'Invoice'])
                <th class="px-6 py-4 font-semibold">Customer</th>
                @include('partials.sortable-th', ['field' => 'grand_total', 'label' => 'Total'])
                @include('partials.sortable-th', ['field' => 'status', 'label' => 'Status'])
                @include('partials.sortable-th', ['field' => 'sale_date', 'label' => 'Date'])
                <th class="px-6 py-4 font-semibold text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($sales as $sale)
                <tr class="hover:bg-indigo-50/50">
                    <td class="px-6 py-4">{{ $sale->id }}</td>
                    <td class="px-6 py-4 font-semibold text-indigo-600">{{ $sale->invoice_no }}</td>
                    <td class="px-6 py-4">{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                    <td class="px-6 py-4 font-bold">PKR {{ number_format($sale->grand_total, 0) }}</td>
                    <td class="px-6 py-4">
                        @if($sale->status === 'voided')
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">Voided</span>
                        @elseif($sale->due_amount > 0)
                            <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-full">Due PKR {{ number_format($sale->due_amount, 0) }}</span>
                        @else
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-full">Paid</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $sale->sale_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('sales.show', $sale->id) }}" class="px-4 py-3 rounded-lg bg-slate-800 text-white text-xs font-semibold">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-slate-500">No sales yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <section class="p-4">{{ $sales->links() }}</section>
</section>
@endsection
