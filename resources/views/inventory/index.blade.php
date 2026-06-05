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

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form method="GET" action="{{ route('inventory.index') }}">
                <div class="flex flex-wrap gap-3">
                    <div class="w-full md:w-96">
                        <select id="productSearch" name="product_id" class="w-full">
                            <option value="">
                                Select Product
                            </option>
                            @foreach($allProducts as $product)
                                <option
                                    value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-lime-600 hover:bg-lime-700 text-white px-5 py-2 rounded-lg">
                        Search
                    </button>
                    <a href="{{ route('inventory.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-lg">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form method="GET" action="{{ route('inventory.index') }}">
                <div class="flex gap-3 items-center">
                    <div class="w-full">
                        <select name="product_id" id="productSearch"
                            class="w-full border border-slate-300 rounded-lg">
                            <option value="">Search Product...</option>

                            @foreach($allProducts as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('product_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-lime-600 hover:bg-lime-700 text-white px-5 py-2 rounded-lg">
                        Search
                    </button>

                    <a href="{{ route('inventory.index') }}"
                        class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-lg">
                        Reset
                    </a>
                </div>
            </form>
        </div> --}}

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

    @push('scripts')
    <script>
    $(document).ready(function () {

        $('#productSearch').select2({
            placeholder: 'Search Product...',
            allowClear: true,
            width: '100%'
        });

        $('#productSearch').on('change', function () {
            this.form.submit();
        });
    });
    </script>
    @endpush
@endsection
