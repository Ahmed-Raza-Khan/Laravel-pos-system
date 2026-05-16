@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto text-center border p-6 rounded">
        <h2 class="text-2xl font-bold mb-2">
            {{ $product->name }}
        </h2>
        <p class="mb-4 text-gray-500">
            SKU: {{ $product->sku }}
        </p>
        <div class="flex justify-center mb-4">
            {!! DNS1D::getBarcodeHTML($product->barcode,'C128',2,80) !!}
        </div>
        <p class="font-semibold">
            {{ $product->barcode }}
        </p>
        <button onclick="window.print()" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
            Print Barcode
        </button>
    </div>
@endsection