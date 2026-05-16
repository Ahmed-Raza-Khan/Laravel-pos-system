@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900">
            Purchases
        </h2>

        <p class="text-slate-500 text-sm mt-1">
            Manage all purchase records and invoices
        </p>
    </div>

    <a href="{{ route('purchases.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl shadow-sm transition mt-4 sm:mt-0">
        ➕ Add Purchase
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">

    <div class="overflow-x-auto">
        <table class="w-full">

            <thead>
                <tr class="bg-white text-black text-left">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">Invoice</th>
                    <th class="px-6 py-4 font-semibold">Supplier</th>
                    <th class="px-6 py-4 font-semibold">Purchase Date</th>
                    <th class="px-6 py-4 font-semibold">Total Amount</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse($purchases as $purchase)

                    <tr class="hover:bg-rose-50 transition-colors">

                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $purchase->id }}
                        </td>

                        <td class="px-6 py-4 font-bold text-indigo-600">
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="hover:text-indigo-800 hover:underline">
                                {{ $purchase->invoice_no }}
                            </a>
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $purchase->supplier->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-900">
                            PKR {{ number_format($purchase->total_amount, 0) }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">
                                ✓ Active
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="inline-flex items-center gap-1 bg-slate-600 hover:bg-slate-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                    👁 View
                                </a>

                                <a href="{{ route('purchases.edit', $purchase->id) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                    ✎ Edit
                                </a>

                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this purchase?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                        🗑 Delete
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500 font-medium">
                            📦 No purchases found. Create a new purchase!
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

<div class="mt-5">
    {{ $purchases->links() }}
</div>

@endsection