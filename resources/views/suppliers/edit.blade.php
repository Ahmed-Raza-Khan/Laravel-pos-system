@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            @include('partials.back-button', ['href' => route('suppliers.index')])
            <div>
                <h2 class="text-2xl font-bold">Edit Supplier</h2>
            </div>
        </div>
    </div>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name', $supplier->name) }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Company</label>
            <input type="text" name="company" class="w-full border p-2 rounded" value="{{ old('company', $supplier->company) }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Phone</label>
            <input type="text" name="phone" class="w-full border p-2 rounded" value="{{ old('phone', $supplier->phone) }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Address</label>
            <textarea name="address" class="w-full border p-2 rounded">{{ old('address', $supplier->address) }}</textarea>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium mb-2">
                Warehouses
            </label>
            <select name="warehouses[]" id="warehouseSelect" multiple class="w-full">
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}"
                        @if(
                            isset($supplier)
                            &&
                            $supplier->warehouses
                                ->contains($warehouse->id)
                        ) selected
                        @endif>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="1" {{ old('status', $supplier->status) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ old('status', $supplier->status) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>

        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl mt-4">
            Update Supplier
        </button>
    </form>
@endsection