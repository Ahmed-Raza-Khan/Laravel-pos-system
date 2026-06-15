@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fa-solid fa-cart-flatbed text-indigo-600"></i>
                    Purchase Management
                </h1>
                <p class="text-slate-500 mt-1">
                    Manage warehouse purchases and stock approvals
                </p>
            </div>
            <a href="{{ route('purchases.create') }}"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition">
                <i class="fa-solid fa-plus"></i>
                Add Purchase
            </a>
        </div>

        {{-- Toolbar --}}
        @include('partials.index-toolbar', [
            'placeholder' => 'Search invoice, supplier or warehouse...',
        ])

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div class="bg-white rounded-3xl shadow-sm border p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-sm">
                            Total Purchases
                        </p>

                        <h3 class="text-2xl font-bold mt-1">
                            {{ $purchases->total() }}
                        </h3>
                    </div>

                    <i class="fa-solid fa-file-invoice-dollar text-3xl text-indigo-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-sm">
                            Approved
                        </p>

                        <h3 class="text-2xl font-bold text-emerald-600 mt-1">
                            {{ $purchases->where('status', 'approved')->count() }}
                        </h3>
                    </div>

                    <i class="fa-solid fa-circle-check text-3xl text-emerald-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-sm">
                            Pending
                        </p>

                        <h3 class="text-2xl font-bold text-amber-600 mt-1">
                            {{ $purchases->where('status', 'pending')->count() }}
                        </h3>
                    </div>

                    <i class="fa-solid fa-clock text-3xl text-amber-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-sm">
                            Cancelled
                        </p>

                        <h3 class="text-2xl font-bold text-red-600 mt-1">
                            {{ $purchases->where('status', 'cancelled')->count() }}
                        </h3>
                    </div>

                    <i class="fa-solid fa-ban text-3xl text-red-500"></i>
                </div>
            </div>

        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">

            <div class="px-6 py-4 border-b bg-slate-50">
                <h2 class="font-semibold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-table"></i>
                    Purchase Records
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            @include('partials.sortable-th', [
                                'field' => 'id',
                                'label' => '#',
                            ])

                            @include('partials.sortable-th', [
                                'field' => 'invoice_no',
                                'label' => 'Invoice',
                            ])

                            <th class="px-6 py-4 text-left">
                                Supplier
                            </th>

                            <th class="px-6 py-4 text-left">
                                Warehouse
                            </th>

                            @include('partials.sortable-th', [
                                'field' => 'purchase_date',
                                'label' => 'Date',
                            ])

                            @include('partials.sortable-th', [
                                'field' => 'total_amount',
                                'label' => 'Amount',
                            ])

                            @include('partials.sortable-th', [
                                'field' => 'status',
                                'label' => 'Status',
                            ])

                            <th class="px-6 py-4 text-right">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @forelse($purchases as $purchase)
                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4">
                                    {{ $purchase->id }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-indigo-600">

                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="hover:underline">

                                        {{ $purchase->invoice_no }}

                                    </a>

                                </td>

                                <td class="px-6 py-4">
                                    {{ $purchase->supplier?->name ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $purchase->warehouse?->name ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $purchase->purchase_date?->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 font-bold">
                                    {{ $setting->currency ?? 'PKR' }} {{ number_format($purchase->total_amount, 0) }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($purchase->status === 'approved')
                                        <span
                                            class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">

                                            <i class="fa-solid fa-check"></i>

                                            Approved

                                        </span>
                                    @elseif($purchase->status === 'cancelled')
                                        <span
                                            class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">

                                            <i class="fa-solid fa-xmark"></i>

                                            Cancelled

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">

                                            <i class="fa-solid fa-clock"></i>

                                            Pending

                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a href="{{ route('purchases.show', $purchase->id) }}"
                                            class="bg-slate-700 hover:bg-slate-800 text-white w-9 h-9 rounded-lg flex items-center justify-center">

                                            <i class="fa-solid fa-eye"></i>

                                        </a>

                                        @if ($purchase->status === 'pending')
                                            <form method="POST" action="{{ route('purchases.approve', $purchase->id) }}">

                                                @csrf

                                                <button onclick="return confirm('Approve this purchase?')"
                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white w-9 h-9 rounded-lg">

                                                    <i class="fa-solid fa-check"></i>

                                                </button>

                                            </form>

                                            <a href="{{ route('purchases.edit', $purchase->id) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white w-9 h-9 rounded-lg flex items-center justify-center">

                                                <i class="fa-solid fa-pen"></i>

                                            </a>
                                        @endif

                                        @if ($purchase->status !== 'cancelled')
                                            <form method="POST" action="{{ route('purchases.cancel', $purchase->id) }}">

                                                @csrf

                                                <button onclick="return confirm('Cancel this purchase?')"
                                                    class="bg-red-600 hover:bg-red-700 text-white w-9 h-9 rounded-lg">

                                                    <i class="fa-solid fa-ban"></i>

                                                </button>

                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-12 text-slate-500">

                                    <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>

                                    No purchases found.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-5 border-t bg-slate-50">
                {{ $purchases->links() }}
            </div>

        </div>

    </div>
@endsection
