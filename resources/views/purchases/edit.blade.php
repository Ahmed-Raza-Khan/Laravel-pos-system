@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-5">

    <h2 class="text-2xl font-bold">
        Edit Purchase
    </h2>

    <a href="{{ route('purchases.index') }}"
       class="bg-gray-500 text-white px-4 py-2 rounded">
        Back
    </a>

</div>

<form action="{{ route('purchases.update', $purchase->id) }}"
      method="POST"
      class="bg-white p-6 rounded shadow">

    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

        <div>
            <label class="block mb-2 font-medium">
                Supplier
            </label>

            <select name="supplier_id"
                    class="w-full border p-3 rounded">

                @foreach($suppliers as $supplier)

                    <option value="{{ $supplier->id }}"
                        {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>

                        {{ $supplier->name }}

                    </option>

                @endforeach

            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium">
                Purchase Date
            </label>

            <input type="date"
                   name="purchase_date"
                   value="{{ $purchase->purchase_date }}"
                   class="w-full border p-3 rounded">
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

                @foreach($purchase->items as $item)

                    <tr>

                        <td class="p-2 border">

                            <select name="product_id[]"
                                    class="w-full border p-2 rounded">

                                @foreach($products as $product)

                                    <option value="{{ $product->id }}"
                                        {{ $item->product_id == $product->id ? 'selected' : '' }}>

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
                                   value="{{ $item->quantity }}"
                                   class="w-full border p-2 rounded">

                        </td>

                        <td class="p-2 border">

                            <input type="number"
                                   step="0.01"
                                   min="1"
                                   name="purchase_price[]"
                                   value="{{ $item->purchase_price }}"
                                   class="w-full border p-2 rounded">

                        </td>

                        <td class="p-2 border text-center">

                            <button type="button"
                                    onclick="removeRow(this)"
                                    class="bg-red-500 text-white px-3 py-1 rounded">

                                X

                            </button>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="mt-4">

        <button type="button"
                onclick="addRow()"
                class="bg-gray-600 text-white px-4 py-2 rounded">

            Add More Product

        </button>

    </div>

    <div class="mt-5">

        <label class="block mb-2 font-medium">
            Note
        </label>

        <textarea name="note"
                  rows="4"
                  class="w-full border p-3 rounded">{{ $purchase->note }}</textarea>

    </div>

    <div class="mt-5">

        <button type="submit"
                class="bg-yellow-500 text-white px-6 py-3 rounded">

            Update Purchase

        </button>

    </div>

</form>

<script>

    function addRow()
    {
        let row = `
            <tr>

                <td class="p-2 border">

                    <select name="product_id[]"
                            class="w-full border p-2 rounded">

                        <option value="">
                            Select Product
                        </option>

                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
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
                           class="w-full border p-2 rounded">

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

        document.getElementById('product-table')
            .insertAdjacentHTML('beforeend', row);
    }

    function removeRow(button)
    {
        button.closest('tr').remove();
    }

</script>

@endsection