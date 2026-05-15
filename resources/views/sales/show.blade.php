@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-2xl overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Invoice
                        </h2>
                        <p class="text-gray-500 mt-1">
                            {{ $sale->invoice_no }}
                        </p>
                    </div>
                    <button onclick="window.print()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                        Print
                    </button>
                </div>
            </div>
            <div class="p-6">
                <!-- Customer & Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            Customer
                        </h3>
                        <p class="text-gray-600">
                            {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                        </p>
                    </div>
                    <div class="md:text-right">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            Date
                        </h3>
                        <p class="text-gray-600">
                            {{ $sale->sale_date->format('d M Y') }}
                        </p>
                    </div>
                </div>
                <!-- Invoice Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Product
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Qty
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Total
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sale->items as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ $item->product->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        PKR {{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                        PKR {{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="flex justify-end mt-8">
                    <div class="w-full md:w-96">
                        <div class="bg-gray-50 rounded-xl p-5">
                            <div class="flex justify-between py-2 border-b">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">
                                    PKR {{ number_format($sale->subtotal, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-medium text-red-500">
                                    - PKR {{ number_format($sale->discount_amount, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">
                                    PKR {{ number_format($sale->tax_amount, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-3 border-b text-lg font-bold">
                                <span>Grand Total</span>
                                <span class="text-indigo-600">
                                    PKR {{ number_format($sale->grand_total, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <span class="text-gray-600">Paid</span>
                                <span class="font-medium text-green-600">
                                    PKR {{ number_format($sale->paid_amount, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 text-red-600 font-semibold">
                                <span>Due</span>
                                <span>
                                    PKR {{ number_format($sale->due_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
