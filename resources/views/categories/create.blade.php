@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
        @include('partials.back-button', ['href' => route('categories.index')])
        <div>
            <h2 class="text-2xl font-bold">Create Category</h2>
            <p class="text-sm text-slate-500 mt-1">Add a category to organize your products.</p>
        </div>
    </div>
</div>

<form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded-3xl shadow-lg">
    @csrf

    <div class="mb-4">
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-medium">Status</label>
        <select name="status" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 mt-4 rounded-lg">Save Category</button>
</form>

@endsection