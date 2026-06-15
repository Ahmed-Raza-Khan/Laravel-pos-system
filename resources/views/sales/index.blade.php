@extends('layouts.app')

@section('content')

<div class="w-full mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-3xl font-bold flex items-center gap-2 text-slate-900">
                <i class="fa-solid fa-receipt text-indigo-600"></i>
                Sales
            </h2>
            <p class="text-slate-500 mt-1">
                Invoices, dues, voids, and payment history
            </p>
        </div>

        <a href="{{ route('sales.create') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow">
            <i class="fa-solid fa-plus"></i>
            New Sale
        </a>
    </div>

    {{-- Toolbar --}}
    @include('partials.index-toolbar', ['placeholder' => 'Search invoice, customer...'])

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- Header --}}
                <thead class="bg-slate-50 text-slate-700">
                    <tr class="text-left border-b border-slate-200">

                        @include('partials.sortable-th', [
                            'field' => 'id',
                            'label' => '#'
                        ])

                        @include('partials.sortable-th', [
                            'field' => 'invoice_no',
                            'label' => 'Invoice'
                        ])

                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-user mr-2 text-slate-400"></i>
                            Customer
                        </th>

                        @include('partials.sortable-th', [
                            'field' => 'grand_total',
                            'label' => 'Total'
                        ])

                        @include('partials.sortable-th', [
                            'field' => 'status',
                            'label' => 'Status'
                        ])

                        @include('partials.sortable-th', [
                            'field' => 'sale_date',
                            'label' => 'Date'
                        ])

                        <th class="px-6 py-4 font-semibold text-right">
                            Actions
                        </th>

                    </tr>
                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($sales as $sale)

                        <tr class="hover:bg-indigo-50/40 transition">

                            {{-- ID --}}
                            <td class="px-6 py-4 text-slate-600">
                                #{{ $sale->id }}
                            </td>

                            {{-- Invoice --}}
                            <td class="px-6 py-4 font-semibold text-indigo-600 flex items-center gap-2">
                                <i class="fa-solid fa-file-invoice text-indigo-400"></i>
                                {{ $sale->invoice_no }}
                            </td>

                            {{-- Customer --}}
                            <td class="px-6 py-4 text-slate-700">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                        {{ strtoupper(substr($sale->customer?->name ?? 'W', 0, 1)) }}
                                    </div>
                                    <span>
                                        {{ $sale->customer?->name ?? 'Walk-in' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Total --}}
                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $setting->currency ?? 'PKR' }}
                                {{ number_format($sale->grand_total, 0) }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if($sale->status === 'voided')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-ban"></i>
                                        Voided
                                    </span>

                                @elseif($sale->due_amount > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 bg-amber-50 px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-clock"></i>
                                        Due {{ $setting->currency ?? 'PKR' }} {{ number_format($sale->due_amount, 0) }}
                                    </span>

                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Paid
                                    </span>
                                @endif

                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 text-slate-600">
                                <i class="fa-regular fa-calendar mr-1 text-slate-400"></i>
                                {{ $sale->sale_date->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('sales.show', $sale->id) }}"
                                   class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow">

                                    <i class="fa-regular fa-eye"></i>
                                    View
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                                <i class="fa-solid fa-receipt text-2xl mb-2 block"></i>
                                No sales yet.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-slate-100">
            {{ $sales->links() }}
        </div>

    </div>

</div>

@endsection