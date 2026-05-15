@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="flex items-center justify-between mb-6">

            <h2 class="text-2xl font-bold">
                Inventory Management
            </h2>

            <a href="{{ route('inventory.history') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                Inventory History
            </a>

        </div>

        <div class="bg-white shadow rounded-xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-6 py-3 text-left">
                                Product
                            </th>

                            <th class="px-6 py-3 text-left">
                                Stock
                            </th>

                            <th class="px-6 py-3 text-left">
                                Adjust
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($products as $product)
                            <tr>

                                <td class="px-6 py-4">
                                    {{ $product->name }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($product->stock <= 5)
                                        <span class="text-red-600 font-bold">
                                            {{ $product->stock }}
                                        </span>
                                    @else
                                        <span class="text-green-600 font-semibold">
                                            {{ $product->stock }}
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <form method="POST" action="{{ route('inventory.adjust', $product->id) }}"
                                        class="flex flex-wrap gap-2">

                                        @csrf

                                        <select name="type" class="border rounded-lg px-3 py-2">
                                            <option value="add">
                                                Add
                                            </option>

                                            <option value="subtract">
                                                Subtract
                                            </option>
                                        </select>

                                        <input type="number" name="quantity" placeholder="Qty"
                                            class="border rounded-lg px-3 py-2 w-24" required>

                                        <input type="text" name="notes" placeholder="Notes"
                                            class="border rounded-lg px-3 py-2">

                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                                            Save
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
