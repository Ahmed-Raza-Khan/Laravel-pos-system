@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Products</h2>
            <p class="text-slate-500 mt-1">Manage product catalog, stock, and pricing from one place.</p>
        </div>

        <section class="flex flex-wrap gap-2 mt-4 sm:mt-0">
            <a href="{{ route('products.export') }}" class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold">Export CSV</a>
            <a href="{{ route('products.import') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-2xl text-sm font-semibold">Import CSV</a>
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl text-sm font-semibold">Add Product</a>
        </section>
    </div>

    @include('partials.index-toolbar', ['placeholder' => 'Search name, SKU, barcode...'])

    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[1200px]">
            <thead class="bg-white text-black">
                <tr class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-black text-left">
                    @include('partials.sortable-th', ['field' => 'id', 'label' => 'ID'])
                    {{-- <th class="px-6 py-4 font-semibold">Image</th> --}}
                    @include('partials.sortable-th', ['field' => 'name', 'label' => 'Name'])
                    {{-- <th class="px-6 py-4 font-semibold">SKU</th> --}}
                    {{-- <th class="px-6 py-4 font-semibold">Barcode</th> --}}
                    <th class="px-6 py-4 font-semibold">Category</th>
                    <th class="px-6 py-4 font-semibold">Purchase Price</th>
                    <th class="px-6 py-4 font-semibold">Sale Price</th>
                    @include('partials.sortable-th', ['field' => 'stock', 'label' => 'Stock'])
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @forelse($products as $product)
                    <tr class="hover:bg-indigo-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $product->id }}</td>

                        {{-- IMAGE --}}
                        {{-- <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                    class="w-10 h-10 rounded-full object-cover shadow-sm">
                            @else
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-slate-400 text-xs font-bold">N/A</span>
                            @endif
                        </td> --}}

                        {{-- NAME --}}
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $product->name }}</td>

                        {{-- SKU --}}
                        {{-- <td class="px-6 py-4 text-sm text-slate-600">{{ $product->sku }}</td> --}}

                        {{-- BARCODE --}}
                        {{-- <td class="px-6 py-4 text-sm text-slate-600">{{ $product->barcode }}</td> --}}

                        {{-- CATEGORY --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>

                        {{-- BRAND --}}
                        {{-- <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                {{ $product->brand->name ?? 'None' }}
                            </span>
                        </td> --}}

                        {{-- PURCHASE PRICE --}}
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            PKR {{ number_format($product->purchase_price, 0) }}
                        </td>

                        {{-- SALE PRICE --}}
                        <td class="px-6 py-4 text-sm font-medium text-green-600">
                            PKR {{ number_format($product->sale_price, 0) }}
                        </td>

                        {{-- STOCK --}}
                        <td class="px-6 py-4">
                            @if($product->stock > 10)
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">{{ $product->stock }}</span>
                            @elseif($product->stock > 0)
                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">{{ $product->stock }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">Out</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">
                            @if($product->status)
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-bold text-slate-700">Inactive</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-4 py-3 rounded-lg transition">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                
                                <a href="{{ route('products.show', $product->id) }}" class="inline-flex items-center gap-1 bg-slate-500 hover:bg-slate-600 text-white text-xs font-semibold px-4 py-3 rounded-lg transition">
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this product?')" class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-3 rounded-lg transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-6 py-8 text-center text-slate-500 font-medium">
                            📦 No products found. Start by adding a new product!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection