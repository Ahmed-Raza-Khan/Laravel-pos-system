@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-1 py-1">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Inventory Management</h2>
                    <p class="text-slate-500 mt-1">Adjust stock levels and view complete inventory history</p>
                </div>
                <a href="{{ route('inventory.history') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl">
                    Inventory History
                </a>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-white text-black">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">
                                Product
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                Adjust Stock
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @foreach ($products as $product)
                            <tr class="hover:bg-lime-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($product->stock <= 5)
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-700">
                                            {{ $product->stock }} Left
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-bold text-emerald-700">
                                            {{ $product->stock }} Units
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('inventory.adjust', $product->id) }}"
                                        class="flex flex-wrap gap-2">
                                        @csrf

                                        <select name="type" class="border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-lime-500 focus:outline-none">
                                            <option value="add">
                                                Add
                                            </option>
                                            <option value="subtract">
                                                Subtract
                                            </option>
                                        </select>
                                        <input type="number" name="quantity" placeholder="Qty" class="border border-slate-200 rounded-lg px-3 py-2 w-20 text-sm focus:ring-2 focus:ring-lime-500 focus:outline-none" required>

                                        <input type="text" name="notes" placeholder="Notes" class="border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-lime-500 focus:outline-none">

                                        <button class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                            ✓ Save
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
