@extends('layouts.app')

@section('content')
<section class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <section>
        <h2 class="text-3xl font-bold text-slate-900">Purchases</h2>
        <p class="text-slate-500 text-sm mt-1">Approve purchases to add stock to inventory</p>
    </section>
    <a href="{{ route('purchases.create') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition mt-4">Add Purchase</a>
</section>

@include('partials.index-toolbar', ['placeholder' => 'Search invoice or supplier...'])

<section class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
    <section class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    @include('partials.sortable-th', ['field' => 'id', 'label' => '#'])
                    @include('partials.sortable-th', ['field' => 'invoice_no', 'label' => 'Invoice'])
                    <th class="px-6 py-4 font-semibold">Supplier</th>
                    @include('partials.sortable-th', ['field' => 'purchase_date', 'label' => 'Date'])
                    @include('partials.sortable-th', ['field' => 'total_amount', 'label' => 'Amount'])
                    @include('partials.sortable-th', ['field' => 'status', 'label' => 'Status'])
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($purchases as $purchase)
                    <tr class="hover:bg-orange-50">
                        <td class="px-6 py-4">{{ $purchase->id }}</td>
                        <td class="px-6 py-4 font-semibold text-indigo-600">
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="hover:underline">{{ $purchase->invoice_no }}</a>
                        </td>
                        <td class="px-6 py-4">{{ $purchase->supplier?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $purchase->purchase_date?->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold">{{ $setting->currency ?? 'PKR' }} {{ number_format($purchase->total_amount, 0) }}</td>
                        <td class="px-6 py-4">
                            @if($purchase->status === 'approved')
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                    Approved
                                </span>
                            @elseif($purchase->status === 'cancelled')
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                    Cancelled
                                </span>
                            @else
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <section class="inline-flex flex-wrap justify-end gap-1">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="px-3 py-2 rounded bg-slate-800 text-white text-xs" title="View">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                @if($purchase->status === 'pending')
                                    <form method="POST" action="{{ route('purchases.approve', $purchase->id) }}">
                                        @csrf
                                    
                                        <button title="Approve" class="px-3 py-2 rounded bg-emerald-600 text-white text-xs">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('purchases.edit', $purchase->id) }}" title="Edit" class="px-3 py-2 rounded bg-blue-600 text-white text-xs">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                @endif
                                @if($purchase->status !== 'cancelled')
                                    <form method="POST" action="{{ route('purchases.cancel', $purchase->id) }}" onsubmit="return confirm('Cancel this purchase?')">
                                        @csrf
                                        
                                        <button class="px-3 py-2 rounded bg-red-600 text-white text-xs" title="Cancel"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                @endif
                            </section>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-slate-500">No purchases found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
    <section class="p-4">{{ $purchases->links() }}</section>
</section>
@endsection
