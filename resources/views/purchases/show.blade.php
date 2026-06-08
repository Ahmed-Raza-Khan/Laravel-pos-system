@extends('layouts.app')

@section('content')

<div class="w-full mx-auto px-1 py-1">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Purchase Invoice</h2>
            <p class="text-sm text-slate-500">Invoice details and items</p>
        </div>

        <div class="flex items-center gap-2 no-print">
            <a href="{{ route('purchases.index') }}" class="inline-flex items-center gap-2 bg-slate-900 px-4 py-2 text-white rounded-2xl">Back</a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-indigo-600 px-4 py-2 text-white rounded-2xl"><i class="fa-solid fa-print"></i> Print</button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <h3 class="text-sm text-slate-500">Invoice</h3>
                <div class="font-semibold">{{ $purchase->invoice_no }}</div>
            </div>
            <div>
                <h3 class="text-sm text-slate-500">Supplier</h3>
                <div class="font-semibold">{{ $purchase->supplier?->name ?? 'N/A' }}</div>
            </div>
            {{-- <div>
                <h3 class="text-sm text-slate-500">Warehouse</h3>
                <div class="font-semibold">{{ $warehouse->name ?? 'N/A' }}</div>
            </div> --}}
            <div>
                <h3 class="text-sm text-slate-500">Date</h3>
                <div class="font-semibold">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <h3 class="text-sm text-slate-500">Store</h3>
                <div class="font-semibold">{{ $setting->store_name ?? config('app.name', 'Laravel POS') }}</div>
                <p class="text-sm text-slate-500">{{ $setting->store_address }}</p>
                <p class="text-sm text-slate-500">Email: {{ $setting->contact_email }}</p>
                <p class="text-sm text-slate-500">Phone: {{ $setting->contact_phone }}</p>
            </div>
            <div class="text-right md:text-left">
                <h3 class="text-sm text-slate-500">Currency</h3>
                <div class="font-semibold">{{ $setting->currency ?? 'PKR' }}</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-100 text-left">
                        <th class="p-3">Product</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">Unit Price</th>
                        <th class="p-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->items as $item)
                        <tr class="border-t">
                            <td class="p-3 flex items-center gap-3">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 object-cover rounded" />
                                @endif
                                <div>
                                    <div class="font-semibold">{{ $item->product?->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-slate-500">{{ $item->product?->brand?->name ?? '' }}</div>
                                </div>
                            </td>
                            <td class="p-3">{{ $item->quantity }}</td>
                            <td class="p-3">{{ $setting->currency ?? 'PKR' }} {{ number_format($item->purchase_price, 2) }}</td>
                            <td class="p-3">{{ $setting->currency ?? 'PKR' }} {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <div class="text-right">
                <div class="text-sm text-slate-500">Total</div>
                <div class="text-2xl font-bold">{{ $setting->currency ?? 'PKR' }} {{ number_format($purchase->total_amount, 2) }}</div>
            </div>
        </div>

        @if($setting->invoice_terms)
            <section class="mt-6 border-t pt-6">
                <h3 class="font-semibold text-slate-900">Invoice Terms</h3>
                <p class="text-sm text-slate-500 whitespace-pre-line">{{ $setting->invoice_terms }}</p>
            </section>
        @endif

        @if($setting->invoice_footer)
            <section class="mt-6 border-t pt-6 bg-slate-50 text-sm text-slate-500">
                {!! nl2br(e($setting->invoice_footer)) !!}
            </section>
        @endif
    </div>

</div>

@endsection
