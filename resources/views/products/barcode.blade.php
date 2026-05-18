@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto text-center border bg-white p-6 rounded-3xl shadow-lg">
        <h2 class="text-2xl font-bold mb-2">
            {{ $product->name }}
        </h2>
        <p class="mb-4 text-gray-500">
            SKU: {{ $product->sku }}
        </p>
        <div class="flex justify-center mb-9 mt-12">
            {!! DNS1D::getBarcodeHTML($product->barcode,'C128',2,80) !!}
        </div>
        <p class="font-semibold">
            {{ $product->barcode }}
        </p>
        <button onclick="window.print()" class="mt-9 bg-slate-900 text-white px-4 py-2 rounded-2xl">
            Print Barcode
        </button>
    </div>
@endsection