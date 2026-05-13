@extends('layouts.app')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-bold">Create Supplier</h2>
    </div>

    <form action="{{ route('suppliers.store') }}"
        method="POST"
        class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}">

            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Company</label>
            <input type="text" name="company" class="w-full border p-2 rounded" value="{{ old('company') }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Phone</label>
            <input type="text" name="phone" class="w-full border p-2 rounded" value="{{ old('phone') }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Address</label>
            <textarea name="address" class="w-full border p-2 rounded">{{ old('address') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Save Supplier
        </button>
    </form>
@endsection