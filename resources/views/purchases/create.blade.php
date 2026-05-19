@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-bold">
            Create Purchase
        </h2>

        <a href="{{ route('purchases.index') }}"
        class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition">
            Back
        </a>
    </div>

    <form action="{{ route('purchases.store') }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block mb-2 font-medium">
                    Supplier
                </label>

                <select name="supplier_id" class="select2 w-full border p-3 rounded">
                    <option value="">
                        Select Supplier
                    </option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
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

            <div>
                <label class="block mb-2 font-medium">
                    Purchase Date
                </label>

                <input type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" class="w-full border p-3 rounded">
                @error('purchase_date')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">
                            Product
                        </th>
                        <th class="p-3 border w-32">
                            Quantity
                        </th>
                        <th class="p-3 border w-40">
                            Purchase Price
                        </th>
                        <th class="p-3 border w-20">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="product-table">
                    <tr>
                        <td class="p-2 border">
                            <select name="product_id[]" class="select2 product-select w-full border p-2 rounded" onchange="setPrice(this)">
                                <option value="">
                                    Select Product
                                </option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}">
                                        {{ $product->name }}
                                        (Stock: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-2 border">
                            <input type="number" name="quantity[]" min="1" class="w-full border p-2 rounded">
                        </td>
                        <td class="p-2 border">
                            <input type="number" step="0.01" name="purchase_price[]" min="1" class="purchase-price w-full border p-2 rounded">
                        </td>
                        <td class="p-2 border text-center">
                            <button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-3 py-1 rounded">
                                X
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <button type="button" onclick="addRow()" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition">
                Add More Product
            </button>
        </div>
        <div class="mt-5">
            <label class="block mb-2 font-medium">
                Note
            </label>
            <textarea name="note" rows="4" class="w-full border p-3 rounded">{{ old('note') }}</textarea>
        </div>
        <div class="mt-5">
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition">
                Save Purchase
            </button>
        </div>
    </form>

    <script>
        function setPrice(selectElement)
        {
            let price = selectElement.options[selectElement.selectedIndex].dataset.price;
            let row = selectElement.closest('tr');
            row.querySelector('.purchase-price').value = price ?? '';
        }

        function addRow()
        {
            let row = `
                <tr>
                    <td class="p-2 border">
                        <select name="product_id[]"
                                class="select2 product-select w-full border p-2 rounded"
                                onchange="setPrice(this)">
                            <option value="">
                                Select Product
                            </option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                        data-price="{{ $product->purchase_price }}">
                                    {{ $product->name }}
                                    (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td class="p-2 border">
                        <input type="number"
                            name="quantity[]"
                            min="1"
                            class="w-full border p-2 rounded">
                    </td>

                    <td class="p-2 border">
                        <input type="number"
                            step="0.01"
                            min="1"
                            name="purchase_price[]"
                            class="purchase-price w-full border p-2 rounded">
                    </td>

                    <td class="p-2 border text-center">
                        <button type="button"
                                onclick="removeRow(this)"
                                class="bg-red-500 text-white px-3 py-1 rounded">
                            X
                        </button>
                    </td>
                </tr>
            `;

            $('#product-table').append(row);
            $('#product-table .select2').last().select2({
                width: '100%'
            });
        }

        function removeRow(button)
        {
            button.closest('tr').remove();
        }
    </script>
@endsection