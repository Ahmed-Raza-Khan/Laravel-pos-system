@extends('layouts.app')

@section('content')
    <div class="flex justify-between mb-5">
        <h2 class="text-2xl font-bold">
            Products
        </h2>

        <a href="{{ route('products.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Product
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr class="border-t">
                        <td class="p-3">{{ $product->id }}</td>
                        <td class="p-3">{{ $product->name }}</td>
                        <td class="p-3">{{ $product->category->name }}</td>
                        <td class="p-3">{{ $product->price }}</td>
                        <td class="p-3">{{ $product->stock }}</td>
                        <td class="p-3">
                            <span class="{{ $product->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-5 text-center text-gray-500">
                            No products found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-center">
        {{ $products->links() }}
    </div>
@endsection