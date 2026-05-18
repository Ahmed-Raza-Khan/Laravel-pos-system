@extends('layouts.app')

@section('content')
<section class="w-full mx-auto">
    <section class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
        <section class="p-6 border-b border-slate-100 flex flex-wrap gap-3 justify-between items-start">
            <section>
                <h2 class="text-2xl font-bold text-slate-900">Invoice {{ $sale->invoice_no }}</h2>
                <p class="text-slate-500 mt-1">{{ $sale->sale_date->format('d M Y') }} · {{ ucfirst($sale->status) }}</p>
            </section>

            <section class="flex flex-wrap gap-2">
                <a href="{{ route('sales.index') }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold">← Back</a>
                @if($sale->status !== 'voided')
                    <a href="{{ route('sales.edit', $sale->id) }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Edit</a>

                    <form method="POST" action="{{ route('sales.void', $sale->id) }}" onsubmit="return confirm('Void this sale and restore stock?')">
                        @csrf

                        <button class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700">Void</button>
                    </form>
                @endif
                <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">Print</button>
            </section>
        </section>

        <section class="p-6 grid md:grid-cols-2 gap-6 border-b border-slate-100">
            <section>
                <p class="text-xs font-semibold uppercase text-slate-400">Customer</p>
                <p class="font-medium">{{ $sale->customer?->name ?? 'Walk-in Customer' }}</p>
            </section>
            
            <section class="md:text-right">
                <p class="text-xs font-semibold uppercase text-slate-400">Payment</p>
                <p class="font-medium capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</p>
            </section>
        </section>

        <section class="p-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b text-left text-slate-500"><th class="py-2">Product</th><th class="py-2 text-right">Qty</th><th class="py-2 text-right">Price</th><th class="py-2 text-right">Total</th></tr></thead>
                <tbody class="divide-y">
                    @foreach($sale->items as $item)
                        <tr><td class="py-3">{{ $item->product?->name }}</td><td class="py-3 text-right">{{ $item->quantity }}</td><td class="py-3 text-right">PKR {{ number_format($item->price, 2) }}</td><td class="py-3 text-right font-semibold">PKR {{ number_format($item->total, 2) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="p-6 bg-slate-50 grid sm:grid-cols-2 gap-4 text-sm">
            <p>Subtotal: <strong>PKR {{ number_format($sale->subtotal, 2) }}</strong></p>
            <p>Discount: <strong>PKR {{ number_format($sale->discount_amount, 2) }}</strong></p>
            <p>Tax: <strong>PKR {{ number_format($sale->tax_amount, 2) }}</strong></p>
            <p class="text-lg">Grand Total: <strong class="text-indigo-600">PKR {{ number_format($sale->grand_total, 2) }}</strong></p>
            <p>Paid: <strong class="text-emerald-600">PKR {{ number_format($sale->paid_amount, 2) }}</strong></p>
            <p>Due: <strong class="text-red-600">PKR {{ number_format($sale->due_amount, 2) }}</strong></p>
        </section>

        @if($sale->payments->isNotEmpty())
            <section class="p-6 border-t">
                <h3 class="font-bold text-slate-900 mb-3">Payment History</h3>
                <table class="w-full text-sm">
                    @foreach($sale->payments as $payment)
                        <tr class="border-b"><td class="py-2">{{ $payment->paid_at->format('d M Y H:i') }}</td><td class="py-2 capitalize">{{ str_replace('_',' ',$payment->payment_method) }}</td><td class="py-2 text-right font-semibold">PKR {{ number_format($payment->amount, 2) }}</td></tr>
                    @endforeach
                </table>
            </section>
        @endif

        @if($sale->status !== 'voided' && $sale->due_amount > 0)
            <section class="p-6 border-t bg-emerald-50/50">
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
