@extends('layouts.app')

@section('content')

<div class="w-full mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-3xl font-bold flex items-center gap-2 text-slate-900">
                <i class="fa-solid fa-truck-field text-indigo-600"></i>
                Suppliers
            </h2>
            <p class="text-slate-500 mt-1">
                Manage supplier information and contact details
            </p>
        </div>

        <a href="{{ route('suppliers.create') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow">
            <i class="fa-solid fa-plus"></i>
            Add Supplier
        </a>

    </div>

    {{-- Search --}}
    @include('partials.index-toolbar', ['placeholder' => 'Search suppliers...'])

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-50 text-slate-700">
                    <tr class="border-b border-slate-200 text-left">

                        <th class="px-6 py-4 font-semibold">
                            ID
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            <i class="fa-solid fa-user mr-2 text-slate-400"></i>
                            Supplier
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Company
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Phone
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Address
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Warehouses
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 font-semibold text-right">
                            Actions
                        </th>

                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($suppliers as $supplier)

                        <tr class="hover:bg-orange-50/40 transition">

                            {{-- ID --}}
                            <td class="px-6 py-4 text-slate-500">
                                #{{ $supplier->id }}
                            </td>

                            {{-- NAME --}}
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-2">

                                    <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($supplier->name, 0, 1)) }}
                                    </div>

                                    <span>{{ $supplier->name }}</span>
                                </div>
                            </td>

                            {{-- COMPANY --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $supplier->company ?? '—' }}
                            </td>

                            {{-- PHONE --}}
                            <td class="px-6 py-4 text-slate-600">
                                <i class="fa-solid fa-phone text-slate-400 mr-1"></i>
                                {{ $supplier->phone ?? '—' }}
                            </td>

                            {{-- ADDRESS --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $supplier->address ?? '—' }}
                            </td>

                            {{-- WAREHOUSES --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">

                                    @forelse($supplier->warehouses as $warehouse)
                                        <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fa-solid fa-warehouse text-[10px]"></i>
                                            {{ $warehouse->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">No warehouse</span>
                                    @endforelse

                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">

                                @if($supplier->status)
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Inactive
                                    </span>
                                @endif

                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-xl text-xs">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-xs">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                                <i class="fa-solid fa-truck text-2xl mb-2 block"></i>
                                No suppliers found. Create one to manage your supply chain.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    <div>
        {{ $suppliers->links() }}
    </div>

</div>

@endsection