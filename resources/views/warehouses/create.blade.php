@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-2 sm:px-4">
    <div class="mb-6">
        <a href="{{ route('warehouses.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-900 transition-colors mb-3">
            <i class="fa-solid fa-arrow-left"></i> Back to Warehouses
        </a>
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-square-plus text-slate-700"></i> Create Warehouse
            </h2>
            <p class="text-slate-500 mt-1">
                Add a new logistics node or storage location to your distribution network.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden w-full">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-slate-400 text-sm"></i> Warehouse Specifications
            </h3>
        </div>

        <form action="{{ route('warehouses.store') }}" method="POST" class="p-6">
            @csrf

            @include('warehouses.partials.form')

            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('warehouses.index') }}" 
                   class="px-5 py-3 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium text-sm transition-all">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-medium px-6 py-3 rounded-xl shadow-sm transition-all transform active:scale-95 text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> Save Warehouse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection