@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
        @include('partials.back-button', ['href' => route('customers.index')])
        <div>
            <h2 class="text-2xl font-bold">Create Customer</h2>
        </div>
    </div>
</div>

<form action="{{ route('customers.store') }}"
      method="POST"
      class="bg-white p-6 rounded-3xl shadow-lg">
    @csrf

    <div class="mb-4">
        <label class="block mb-1">Name</label>

        <input type="text" name="name" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" value="{{ old('name') }}">

        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-1">Email</label>

        <input type="email" name="email" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" value="{{ old('email') }}">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Phone</label>

        <input type="text" name="phone" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" value="{{ old('phone') }}">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Address</label>

        <textarea name="address" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('address') }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Status</label>

        <select name="status" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition mt-4">
        Save Customer
    </button>
</form>

@endsection