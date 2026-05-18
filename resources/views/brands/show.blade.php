@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto">
    <section class="flex items-center gap-4 mb-6">
        @include('partials.back-button', ['href' => route('brands.index')])
        <h1 class="text-2xl font-bold">{{ $brand->name }}</h1>
    </section>
    <section class="rounded-3xl border bg-white p-6 shadow-sm space-y-3">
        <p><span class="text-slate-500">Slug:</span> {{ $brand->slug }}</p>
        <p><span class="text-slate-500">Products:</span> <strong>{{ $brand->products_count }}</strong></p>
        <p class="text-slate-600">{{ $brand->description ?? 'No description.' }}</p>
        <a href="{{ route('brands.edit', $brand->id) }}" class="inline-block mt-4 rounded-xl bg-indigo-600 px-4 py-2 text-white text-sm font-semibold">Edit Brand</a>
    </section>
</section>
@endsection
