@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-1 py-1">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">
                    Sales List
                </h2>
                <p class="text-slate-500 mt-1">Manage all sales transactions and invoices</p>
            </div>
            <a href="{{ route('sales.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-2xl transition mt-4 sm:mt-0">
                ➕ New Sale
            </a>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-white text-black">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">#</th>
                            <th class="px-6 py-4 text-left font-semibold">Invoice</th>
                            <th class="px-6 py-4 text-left font-semibold">Customer</th>
                            <th class="px-6 py-4 text-left font-semibold">Total</th>
                            <th class="px-6 py-4 text-left font-semibold">Payment</th>
                            <th class="px-6 py-4 text-left font-semibold">Date</th>
                            <th class="px-6 py-4 text-right font-semibold">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-teal-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $sale->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                    {{ $sale->invoice_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">
                                    PKR {{ number_format($sale->grand_total, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">
                                        {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $sale->sale_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('sales.show', $sale->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-slate-600 hover:bg-slate-700 text-white text-xs font-semibold rounded-lg transition">
                                        👁 View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    💰 No sales found. Create your first sale!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">
            {{ $sales->links() }}
        </div>
    </div>
@endsection
