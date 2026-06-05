@extends('layouts.app')

@section('content')

<div class="w-full mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <h2 class="text-2xl font-bold mb-6">
            Create Warehouse
        </h2>

        <form action="{{ route('warehouses.store') }}"
              method="POST">

            @csrf

            @include('warehouses.partials.form')

            <div class="mt-6">

                <button
                    class="bg-slate-900 text-white px-5 py-3 rounded-xl">
                    Save Warehouse
                </button>

            </div>

        </form>

    </div>

</div>

@endsection