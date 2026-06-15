@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-3">
                    <i class="fas fa-cart-plus text-indigo-600"></i>
                    Create Purchase
                </h1>

                <p class="text-slate-500 mt-2">
                    Create a new supplier purchase for a warehouse
                </p>
            </div>
            <a href="{{ route('purchases.index') }}"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar"></i>
                        Purchase Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label class="font-semibold text-slate-700 mb-2 block">
                                <i class="fas fa-warehouse text-indigo-600 mr-2"></i>
                                Warehouse
                            </label>
                            <select id="warehouse_id" name="warehouse_id" class="select2 w-full">
                                <option value="">
                                    Select Warehouse
                                </option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-semibold text-slate-700 mb-2 block">
                                <i class="fas fa-truck text-emerald-600 mr-2"></i>
                                Supplier
                            </label>
                            <select id="supplier_id" name="supplier_id" class="select2 w-full">
                                <option value="">
                                    First Select Warehouse
                                </option>
                            </select>
                            @error('supplier_id')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-semibold text-slate-700 mb-2 block">
                                <i class="fas fa-calendar text-orange-500 mr-2"></i>
                                Purchase Date
                            </label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}"
                                class="w-full rounded-xl border-slate-300">
                            @error('purchase_date')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 mt-8 overflow-hidden">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-boxes text-indigo-600"></i>
                            Purchase Products
                        </h2>
                        <button type="button" onclick="addRow()"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl shadow">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Add Product
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="p-4 text-left">
                                    <i class="fas fa-box mr-2"></i>
                                    Product
                                </th>
                                <th class="p-4 text-left">
                                    <i class="fas fa-layer-group mr-2"></i>
                                    Quantity
                                </th>
                                <th class="p-4 text-left">
                                    <i class="fas fa-money-bill-wave mr-2"></i>
                                    Purchase Price
                                </th>
                                <th class="p-4 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody id="product-table">
                            <tr>
                                <td class="p-3">
                                    <select name="product_id[]" class="select2 product-select w-full"
                                        onchange="setPrice(this)">
                                        <option value="">
                                            Select Product
                                        </option>

                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-3">
                                    <input type="number" name="quantity[]" min="1"
                                        class="w-full rounded-xl border-slate-300">
                                </td>
                                <td class="p-3">
                                    <input type="number" step="0.01" name="purchase_price[]"
                                        class="purchase-price w-full rounded-xl border-slate-300">
                                </td>
                                <td class="p-3 text-center">
                                    <button type="button" onclick="removeRow(this)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 mt-8 p-6">

                <label class="font-semibold text-slate-700 mb-2 block">
                    <i class="fas fa-note-sticky mr-2 text-yellow-500"></i>
                    Note
                </label>

                <textarea name="note" rows="4" class="w-full rounded-xl border-slate-300">{{ old('note') }}</textarea>

            </div>

            <div class="mt-8 flex justify-end">

                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl shadow-lg font-semibold">

                    <i class="fas fa-save mr-2"></i>
                    Save Purchase

                </button>

            </div>

        </form>
    </div>

    <script>
        function setPrice(selectElement) {
            let price =
                selectElement.options[
                    selectElement.selectedIndex
                ].dataset.price;

            let row =
                selectElement.closest('tr');

            row.querySelector('.purchase-price').value =
                price ?? '';
        }

        function removeRow(button) {
            button.closest('tr').remove();
        }

        function addRow() {
            let row = `
                    <tr>
                        <td class="p-3">
                            <select
                                name="product_id[]"
                                class="select2 product-select w-full"
                                onchange="setPrice(this)">

                                <option value="">
                                    Select Product
                                </option>

                                @foreach ($products as $product)

                                <option
                                    value="{{ $product->id }}"
                                    data-price="{{ $product->purchase_price }}">

                                    {{ $product->name }}

                                </option>

                                @endforeach

                            </select>

                        </td>

                        <td class="p-3">
                            <input type="number"
                                    min="1"
                                    name="quantity[]"
                                    class="w-full rounded-xl border-slate-300">
                        </td>

                        <td class="p-3">
                            <input type="number"
                                    step="0.01"
                                    name="purchase_price[]"
                                    class="purchase-price w-full rounded-xl border-slate-300">
                            </td>

                            <td class="p-3 text-center">

                                <button
                                    type="button"
                                    onclick="removeRow(this)"
                                    class="bg-red-500 text-white px-4 py-2 rounded-xl">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </td>

                        </tr> `;
            $('#product-table').append(row);
            $('#product-table .select2')
                .last()
                .select2({
                    width: '100%'
                });
        }

        $('#warehouse_id').on('change', function() {
            let warehouseId = $(this).val();
            if (!warehouseId) {
                $('#supplier_id').html(
                    '<option>Select Warehouse First</option>'
                );
                return;
            }

            $.get(
                '/warehouses/' +
                warehouseId +
                '/suppliers',
                function(data) {
                    let options =
                        '<option value="">Select Supplier</option>';
                    data.forEach(function(supplier) {
                        options +=
                            `<option value="${supplier.id}">
                            ${supplier.name}
                        </option>`;
                    });
                    $('#supplier_id').html(options);
                }
            );
        });
    </script>
@endsection
