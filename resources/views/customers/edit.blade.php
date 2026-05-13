@extends('layouts.app')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-bold">Edit Customer</h2>
    </div>
    <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Name</label>

            <input type="text"
                name="name"
                class="w-full border p-2 rounded"
                value="{{ old('name', $customer->name) }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Email</label>

            <input type="email"
                name="email"
                class="w-full border p-2 rounded"
                value="{{ old('email', $customer->email) }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Phone</label>

            <input type="text"
                name="phone"
                class="w-full border p-2 rounded"
                value="{{ old('phone', $customer->phone) }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Address</label>

            <textarea name="address"
                    class="w-full border p-2 rounded">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Status</label>

            <select name="status"
                    class="w-full border p-2 rounded">

                <option value="1"
                    {{ old('status', $customer->status) == 1 ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ old('status', $customer->status) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>
        </div>

        <button type="submit"
                class="bg-yellow-500 text-white px-4 py-2 rounded">
            Update Customer
        </button>
    </form>
@endsection