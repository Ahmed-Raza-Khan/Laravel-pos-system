@extends('layouts.app')

@section('content')
<section class="w-full mx-auto">
    <section class="mb-6 flex items-center gap-4">
        @include('partials.back-button', ['href' => route('products.index')])

        <h1 class="text-2xl font-bold">Import Products (CSV)</h1>
    </section>
    
    <section class="rounded-3xl border bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-600 mb-4">Columns: name, sku, barcode, category_id, brand_id, purchase_price, sale_price, stock, description, status</p>
        <form method="POST" action="{{ route('products.import.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="file" name="file" accept=".csv,.txt" required class="w-150 mb-4 border-2 border-indigo-600 p-3">
            <br>
            <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-white font-semibold">Import</button>
        </form>
        <a href="{{ route('products.export') }}" class="inline-block mt-5 text-sm text-indigo-600 font-semibold">Download sample export CSV</a>
    </section>
</section>
@endsection
