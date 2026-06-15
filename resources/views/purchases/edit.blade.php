```blade
@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    <i class="fa-solid fa-file-pen text-blue-600 mr-2"></i>
                    Edit Purchase
                </h1>
                <p class="text-slate-500 mt-1">
                    Update purchase information and products
                </p>
            </div>

            <a href="{{ route('purchases.index') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>

        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" class="bg-white rounded-3xl shadow-lg overflow-hidden">
            @csrf
            @method('PUT')
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
                <h2 class="text-slate-800 text-xl font-semibold">
                    <i class="fa-solid fa-cart-shopping mr-2"></i>
                    Purchase Information
                </h2>
            </div>

            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                    {{-- Warehouse --}}
                    <div>
                        <label class="block mb-2 font-semibold text-slate-700">
                            <i class="fa-solid fa-warehouse mr-2 text-indigo-600"></i>
                            Warehouse
                        </label>

                        <select id="warehouse_id" name="warehouse_id" class="select2 w-full">

                            <option value="">
                                Select Warehouse
                            </option>

                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ $purchase->warehouse_id == $warehouse->id ? 'selected' : '' }}>
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

                    {{-- Supplier --}}
                    <div>
                        <label class="block mb-2 font-semibold text-slate-700">
                            <i class="fa-solid fa-truck-field mr-2 text-green-600"></i>
                            Supplier
                        </label>

                        <select id="supplier_id" name="supplier_id" class="select2 w-full">

                            <option value="">
                                Select Supplier
                            </option>

                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('supplier_id')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="block mb-2 font-semibold text-slate-700">
                            <i class="fa-solid fa-calendar-days mr-2 text-orange-600"></i>
                            Purchase Date
                        </label>

                        <input type="date" name="purchase_date"
                            value="{{ old('purchase_date', \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d')) }}"
                            class="w-full border rounded-xl p-3">
                    </div>

                </div>

                {{-- Products --}}
                <div class="border rounded-2xl overflow-hidden">

                    <div class="bg-slate-100 px-5 py-4">
                        <h3 class="font-semibold text-slate-700">
                            <i class="fa-solid fa-boxes-stacked mr-2"></i>
                            Products
                        </h3>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-slate-50">

                                <tr>
                                    <th class="p-4 text-left">
                                        <i class="fa-solid fa-box mr-2"></i>
                                        Product
                                    </th>

                                    <th class="p-4 text-left">
                                        <i class="fa-solid fa-layer-group mr-2"></i>
                                        Quantity
                                    </th>

                                    <th class="p-4 text-left">
                                        <i class="fa-solid fa-money-bill-wave mr-2"></i>
                                        Purchase Price
                                    </th>

                                    <th class="p-4 text-center">
                                        Action
                                    </th>
                                </tr>

                            </thead>

                            <tbody id="product-table">

                                @foreach ($purchase->items as $item)
                                    <tr>

                                        <td class="p-3 border-t">

                                            <select name="product_id[]" class="select2 w-full product-select"
                                                onchange="setPrice(this)">

                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        data-price="{{ $product->purchase_price }}"
                                                        {{ $item->product_id == $product->id ? 'selected' : '' }}>

                                                        {{ $product->name }}

                                                    </option>
                                                @endforeach

                                            </select>

                                        </td>

                                        <td class="p-3 border-t">

                                            <input type="number" name="quantity[]" min="1"
                                                value="{{ $item->quantity }}" class="w-full border rounded-lg p-2">

                                        </td>

                                        <td class="p-3 border-t">

                                            <input type="number" step="0.01" min="1" name="purchase_price[]"
                                                value="{{ $item->purchase_price }}"
                                                class="purchase-price w-full border rounded-lg p-2">

                                        </td>

                                        <td class="p-3 border-t text-center">

                                            <button type="button" onclick="removeRow(this)"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="mt-5">

                    <button type="button" onclick="addRow()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

                        <i class="fa-solid fa-plus mr-2"></i>
                        Add Product

                    </button>

                </div>

                <div class="mt-6">

                    <label class="block mb-2 font-semibold">
                        <i class="fa-solid fa-note-sticky mr-2"></i>
                        Note
                    </label>

                    <textarea name="note" rows="4" class="w-full border rounded-xl p-3">{{ old('note', $purchase->note) }}</textarea>

                </div>

                <div class="mt-6">

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                        Update Purchase

                    </button>

                </div>

            </div>

        </form>

    </div>

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                width: '100%'
            });

            $('#warehouse_id').change(function() {

                let warehouseId = $(this).val();

                $('#supplier_id').html('<option>Loading...</option>');

                $.ajax({
                    url: '/warehouses/' + warehouseId + '/suppliers',

                    success: function(data) {

                        let options =
                            '<option value="">Select Supplier</option>';

                        data.forEach(function(supplier) {

                            options += `
                        <option value="${supplier.id}">
                            ${supplier.name}
                        </option>
                    `;

                        });

                        $('#supplier_id').html(options);
                    }
                });
            });

        });

        function setPrice(selectElement) {
            let price =
                selectElement.options[
                    selectElement.selectedIndex
                ].dataset.price;

            let row =
                selectElement.closest('tr');

            row.querySelector('.purchase-price')
                .value = price ?? '';
        }

        function addRow() {
            let row = `
        <tr>

            <td class="p-3 border-t">

                <select name="product_id[]"
                    class="select2 w-full product-select"
                    onchange="setPrice(this)">

                    <option value="">
                        Select Product
                    </option>

                    @foreach ($products as $product)

                        <option value="{{ $product->id }}"
                            data-price="{{ $product->purchase_price }}">

                            {{ $product->name }}

                        </option>

                    @endforeach

                </select>

            </td>

            <td class="p-3 border-t">

                <input type="number"
                    name="quantity[]"
                    min="1"
                    class="w-full border rounded-lg p-2">

            </td>

            <td class="p-3 border-t">

                <input type="number"
                    step="0.01"
                    min="1"
                    name="purchase_price[]"
                    class="purchase-price w-full border rounded-lg p-2">

            </td>

            <td class="p-3 border-t text-center">

                <button type="button"
                    onclick="removeRow(this)"
                    class="bg-red-500 text-white px-3 py-2 rounded-lg">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </td>

        </tr>
    `;

            $('#product-table').append(row);

            $('#product-table .select2')
                .last()
                .select2({
                    width: '100%'
                });
        }

        function removeRow(button) {
            button.closest('tr').remove();
        }
    </script>
@endsection
