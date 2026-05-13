@extends('layouts.app')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-bold">Edit Supplier</h2>
    </div>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="bg-white p-6 rounded shadow">
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

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">
            Update Supplier
        </button>
    </form>
@endsection