@extends('layouts.app')

@push('styles')
    <style>
    @media print {

        @page {
            size: A4;
            margin: 5mm;
        }

        /* Hide non-print elements */
        .no-print,
        aside,
        nav,
        header,
        footer,
        .sidebar,
        .navbar {
            display: none !important;
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: auto !important;
            background: #fff !important;
        }

        /* Reset Laravel layout */
        #app,
        main,
        .main-content,
        .content,
        .container,
        .wrapper,
        .lg\:ml-64,
        .ml-64,
        .lg\:pl-64,
        .pl-64 {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        /* Print area takes full page */
        .print-area {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Invoice card full width */
        .print-area > section {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        th,
        td {
            padding: 8px !important;
        }

        * {
            box-shadow: none !important;
        }
    }
    </style>
@endpush

@section('content')
<section class="w-full max-w-none print-area">
    <section class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
        <section class="p-6 border-b border-slate-100">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    @if($setting->invoice_logo)
                        <img src="{{ asset('storage/' . $setting->invoice_logo) }}" alt="{{ $setting->store_name }}" class="h-20 object-contain" />
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $setting->store_name ?? config('app.name', 'Laravel POS') }}</h1>
                        <p class="text-sm text-slate-500">{{ $setting->store_address }}</p>
                        <p class="text-sm text-slate-500">Email: {{ $setting->contact_email }} | Phone: {{ $setting->contact_phone }}</p>
                    </div>
                </div>

                <div class="space-y-2 text-left lg:text-right">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Invoice</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $sale->invoice_no }}</p>
                    <p class="text-sm text-slate-500">{{ $sale->sale_date->format('d M Y') }}</p>
                    <p class="text-sm text-slate-500 capitalize">Status: {{ $sale->status }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3 justify-between items-center no-print">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sales.index') }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">← Back</a>
                    @if($sale->status !== 'voided')
                        <a href="{{ route('sales.edit', $sale->id) }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <form method="POST" action="{{ route('sales.void', $sale->id) }}" onsubmit="return confirm('Void this sale and restore stock?')" class="inline-block">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700">Void</button>
                        </form>
                    @endif
                </div>
                <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    <i class="fa-solid fa-print"></i> Print
                </button>
            </div>
        </section>

        <section class="p-6 grid md:grid-cols-2 gap-6 border-b border-slate-100">
            <section>
                <p class="text-xs font-semibold uppercase text-slate-400">Customer</p>
                <p class="font-medium">{{ $sale->customer?->name ?? 'Walk-in Customer' }}</p>
                @if($sale->customer)
                    <p class="text-sm text-slate-500">{{ $sale->customer->phone ?? '' }}</p>
                    <p class="text-sm text-slate-500">{{ $sale->customer->email ?? '' }}</p>
                @endif
            </section>
            
            <section class="md:text-right">
                <p class="text-xs font-semibold uppercase text-slate-400">Payment</p>
                <p class="font-medium capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</p>
                <p class="text-sm text-slate-500">Currency: {{ $setting->currency ?? 'PKR' }}</p>
            </section>
        </section>

        <section class="p-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b text-left text-slate-500"><th class="py-2">Product</th><th class="py-2 text-right">Qty</th><th class="py-2 text-right">Price</th><th class="py-2 text-right">Total</th></tr></thead>
                <tbody class="divide-y">
                    @foreach($sale->items as $item)
                        <tr><td class="py-3">{{ $item->product?->name }}</td><td class="py-3 text-right">{{ $item->quantity }}</td><td class="py-3 text-right">{{ $setting->currency ?? 'PKR' }} {{ number_format($item->price, 2) }}</td><td class="py-3 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($item->total, 2) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="p-6 bg-slate-50 grid sm:grid-cols-2 gap-4 text-sm">
            <p>Subtotal: <strong>{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->subtotal, 2) }}</strong></p>
            <p>Discount: <strong>{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->discount_amount, 2) }}</strong></p>
            <p>Tax ({{ $sale->tax_percentage }}%): <strong>{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->tax_amount, 2) }}</strong></p>
            <p class="text-lg">Grand Total: <strong class="text-indigo-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->grand_total, 2) }}</strong></p>
            <p>Paid: <strong class="text-emerald-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->paid_amount, 2) }}</strong></p>
            <p>Due: <strong class="text-red-600">{{ $setting->currency ?? 'PKR' }} {{ number_format($sale->due_amount, 2) }}</strong></p>
        </section>

        @if($setting->invoice_terms)
            <section class="p-6 border-t">
                <h3 class="font-semibold text-slate-900">Invoice Terms</h3>
                <p class="text-sm text-slate-500 whitespace-pre-line">{{ $setting->invoice_terms }}</p>
            </section>
        @endif

        @if($setting->invoice_footer)
            <section class="p-6 border-t bg-slate-50 text-sm text-slate-500">
                {!! nl2br(e($setting->invoice_footer)) !!}
            </section>
        @endif

        @if($sale->payments->isNotEmpty())
            <section class="p-6 border-t">
                <h3 class="font-bold text-slate-900 mb-3">Payment History</h3>
                <table class="w-full text-sm">
                    @foreach($sale->payments as $payment)
                        <tr class="border-b"><td class="py-2">{{ $payment->paid_at->format('d M Y H:i') }}</td><td class="py-2 capitalize">{{ str_replace('_',' ',$payment->payment_method) }}</td><td class="py-2 text-right font-semibold">{{ $setting->currency ?? 'PKR' }} {{ number_format($payment->amount, 2) }}</td></tr>
                    @endforeach
                </table>
            </section>
        @endif

        @if($sale->status !== 'voided' && $sale->due_amount > 0)
            <section class="p-6 border-t bg-emerald-50/50 collect-payment-section no-print">
                <h3 class="font-bold text-slate-900 mb-4">Collect Due Payment</h3>
                <form method="POST" action="{{ route('sales.payment', $sale->id) }}" class="grid sm:grid-cols-3 gap-4 max-w-2xl">
                    @csrf
                    <section>
                        <label class="text-xs font-semibold text-slate-600">Amount (max {{ number_format($sale->due_amount, 2) }})</label>
                        <input type="number" step="0.01" name="amount" max="{{ $sale->due_amount }}" required class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                    </section>
                    <section>
                        <label class="text-xs font-semibold text-slate-600">Method</label>
                        <select name="payment_method" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="easypaisa">Easypaisa</option>
                            <option value="jazzcash">JazzCash</option>
                        </select>
                    </section>
                    <section class="flex items-end">
                        <button class="w-full rounded-xl bg-emerald-600 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Record Payment</button>
                    </section>
                </form>
            </section>
        @endif
    </section>
</section>
@endsection
