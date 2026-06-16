@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Purchase Invoice
                </h1>
                <p class="text-slate-500 mt-1">
                    Complete purchase information and invoice details
                </p>
            </div>

            <div class="flex gap-3 no-print">
                <a href="{{ route('purchases.index') }}"
                    class="px-5 py-3 rounded-2xl bg-slate-900 text-white hover:bg-slate-800 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Back
                </a>
                <button onclick="window.print()"
                    class="px-5 py-3 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-print mr-2"></i>
                    Print Invoice
                </button>
            </div>
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
            {{-- Top Header --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-700 text-slate-900 p-8">
                <div class="flex flex-col md:flex-row justify-between">
                    <div>
                        <h2 class="text-3xl font-bold">
                            {{ $setting->store_name ?? config('app.name') }}
                        </h2>
                        <p class="text-slate-500 mt-2">
                            {{ $setting->store_address }}
                        </p>

                        <p class="text-slate-500">
                            {{ $setting->contact_email }}
                        </p>

                        <p class="text-slate-500">
                            {{ $setting->contact_phone }}
                        </p>
                    </div>

                    <div class="text-right mt-6 md:mt-0">

                        <h3 class="text-4xl font-bold">
                            PURCHASE
                        </h3>

                        <p class="mt-3 text-slate-500">
                            Invoice #
                        </p>

                        <p class="text-xl font-semibold">
                            {{ $purchase->invoice_no }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Purchase Details --}}
            <div class="p-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                    {{-- Supplier --}}
                    <div class="bg-slate-50 rounded-2xl p-5">

                        <h4 class="text-sm uppercase tracking-wider text-slate-500 mb-3">
                            Supplier Details
                        </h4>

                        <p class="font-bold text-lg text-slate-900">
                            {{ $purchase->supplier?->name ?? 'N/A' }}
                        </p>

                    </div>

                    {{-- Purchase Info --}}
                    <div class="bg-slate-50 rounded-2xl p-5">

                        <h4 class="text-sm uppercase tracking-wider text-slate-500 mb-3">
                            Purchase Information
                        </h4>

                        <div class="space-y-2">

                            <div class="flex justify-between">
                                <span class="text-slate-500">Date</span>
                                <span class="font-semibold">
                                    {{ $purchase->purchase_date?->format('d M Y') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Warehouse</span>
                                <span class="font-semibold">
                                    {{ $purchase->warehouse?->name ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Status</span>

                                @if ($purchase->status == 'approved')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Approved
                                    </span>
                                @elseif($purchase->status == 'cancelled')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Cancelled
                                    </span>
                                @else
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Pending
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Items Table --}}
                <div class="overflow-x-auto rounded-2xl border border-slate-200">

                    <table class="w-full">

                        <thead class="bg-slate-100">

                            <tr>

                                <th class="px-5 py-4 text-left">
                                    Product
                                </th>

                                <th class="px-5 py-4 text-center">
                                    Qty
                                </th>

                                <th class="px-5 py-4 text-right">
                                    Purchase Price
                                </th>

                                <th class="px-5 py-4 text-right">
                                    Sub Total
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($purchase->items as $item)
                                <tr class="border-t hover:bg-slate-50">

                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            @if ($item->product?->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    class="w-14 h-14 rounded-xl object-cover border">
                                            @endif

                                            <div>

                                                <div class="font-semibold">
                                                    {{ $item->product?->name }}
                                                </div>

                                                <div class="text-sm text-slate-500">
                                                    {{ $item->product?->brand?->name }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-5 py-4 text-center font-semibold">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        {{ $setting->currency ?? 'PKR' }}
                                        {{ number_format($item->purchase_price, 2) }}
                                    </td>

                                    <td class="px-5 py-4 text-right font-bold">
                                        {{ $setting->currency ?? 'PKR' }}
                                        {{ number_format($item->subtotal, 2) }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- Totals --}}
                <div class="flex justify-end mt-8">

                    <div class="w-full md:w-96">

                        <div class="bg-slate-50 rounded-2xl p-6">

                            <div class="flex justify-between text-lg">

                                <span class="font-semibold">
                                    Total Amount
                                </span>

                                <span class="font-bold text-2xl text-indigo-600">

                                    {{ $setting->currency ?? 'PKR' }}
                                    {{ number_format($purchase->total_amount, 2) }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Notes --}}
                @if ($purchase->note)
                    <div class="mt-8">

                        <h3 class="font-semibold text-slate-900 mb-2">
                            Purchase Note
                        </h3>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 text-slate-700">
                            {{ $purchase->note }}
                        </div>

                    </div>
                @endif

                {{-- Terms --}}
                @if ($setting->invoice_terms)
                    <div class="mt-8 border-t pt-6">

                        <h3 class="font-semibold mb-2">
                            Terms & Conditions
                        </h3>

                        <p class="text-slate-600 whitespace-pre-line">
                            {{ $setting->invoice_terms }}
                        </p>

                    </div>
                @endif

                {{-- Footer --}}
                @if ($setting->invoice_footer)
                    <div class="mt-8 bg-slate-50 border rounded-2xl p-5 text-center text-slate-600">

                        {!! nl2br(e($setting->invoice_footer)) !!}

                    </div>
                @endif

            </div>

        </div>

    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .shadow-lg {
                box-shadow: none !important;
            }

            .rounded-3xl {
                border-radius: 0 !important;
            }
        }
    </style>
@endsection
