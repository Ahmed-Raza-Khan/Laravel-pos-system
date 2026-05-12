@extends('layouts.app')

@section('content')

<div class="mb-5">
    <h2 class="text-2xl font-bold">Create Category</h2>
</div>

<form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf

    <!-- Name -->
    <div class="mb-4">
        <label class="block mb-1">Name</label>
        <input type="text" name="name"
               class="w-full border p-2 rounded"
               value="{{ old('name') }}">

        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>

        @error('status')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Save Category
    </button>
</form>

@endsection