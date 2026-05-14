@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-5">
    <h2 class="text-2xl font-bold">Products</h2>

    <a href="{{ route('products.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
        Add Product
    </a>
</div>

<div class="bg-white shadow rounded overflow-x-auto">
    <table class="w-full min-w-[1200px]">
        <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">ID</th>
            <th class="p-3">Image</th>
            <th class="p-3">Name</th>
            <th class="p-3">SKU</th>
            <th class="p-3">Barcode</th>
            <th class="p-3">Category</th>
            <th class="p-3">Brand</th>
            <th class="p-3">Purchase Price</th>
            <th class="p-3">Sale Price</th>
            <th class="p-3">Stock</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
        </tr>
        </thead>

        <tbody>
        @forelse($products as $product)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $product->id }}</td>

                {{-- IMAGE --}}
                <td class="p-3">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="w-10 h-10 rounded object-cover">
                    @else
                        <span class="text-gray-400">No Image</span>
                    @endif
                </td>

                {{-- NAME --}}
                <td class="p-3 font-semibold">{{ $product->name }}</td>

                {{-- SKU --}}
                <td class="p-3">{{ $product->sku }}</td>

                {{-- BARCODE --}}
                <td class="p-3">{{ $product->barcode ?? '-' }}</td>

                {{-- CATEGORY --}}
                <td class="p-3">
                    {{ $product->category->name ?? '-' }}
                </td>

                {{-- BRAND --}}
                <td class="p-3">
                    {{ $product->brand->name ?? 'No Brand' }}
                </td>

                {{-- PURCHASE PRICE --}}
                <td class="p-3">
                    {{ number_format($product->purchase_price, 2) }}
                </td>

                {{-- SALE PRICE --}}
                <td class="p-3">
                    {{ number_format($product->sale_price, 2) }}
                </td>

                {{-- STOCK --}}
                <td class="p-3">
                    @if($product->stock > 10)
                        <span class="text-green-600">{{ $product->stock }}</span>
                    @elseif($product->stock > 0)
                        <span class="text-yellow-600">{{ $product->stock }}</span>
                    @else
                        <span class="text-red-600">Out</span>
                    @endif
                </td>

                {{-- STATUS --}}
                <td class="p-3">
                    <span class="{{ $product->status ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                {{-- ACTION --}}
                <td class="p-3 flex gap-2">
                    <a href="{{ route('products.edit', $product->id) }}"
                       class="bg-yellow-500 px-3 py-1 text-white rounded">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete this product?')"
                                class="bg-red-500 px-3 py-1 text-white rounded">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="p-4 text-center text-gray-500">
                    No products found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>

@endsection