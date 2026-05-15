@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">

    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h1 class="text-2xl font-bold">
                    {{ $product->name }}
                </h1>

                <p class="text-gray-500 mt-1">
                    SKU: {{ $product->sku }}
                </p>

            </div>

            <a href="{{ route('products.index') }}"
               class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg">
                Back
            </a>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>

                @if($product->image)

                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        class="w-full h-80 object-cover rounded-xl"
                    >

                @endif

            </div>

            <div>

                <div class="space-y-4">

                    <div>

                        <h3 class="font-semibold text-gray-700">
                            Barcode
                        </h3>

                        <p class="text-gray-600">
                            {{ $product->barcode }}
                        </p>

                    </div>

                    <div class="border rounded-xl p-4 bg-gray-50">

                        {!! DNS1D::getBarcodeHTML(
                            $product->barcode,
                            'C128',
                            2,
                            60
                        ) !!}

                    </div>

                    <a href="{{ route('products.barcode', $product->id) }}"
                       target="_blank"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-block">
                        Print Barcode
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection