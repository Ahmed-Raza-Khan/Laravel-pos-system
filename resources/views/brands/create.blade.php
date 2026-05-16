@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
        @include('partials.back-button', ['href' => route('brands.index')])
        <div>
            <h2 class="text-2xl font-bold">Create Brand</h2>
        </div>
    </div>
</div>

<form action="{{ route('brands.store') }}"
      method="POST"
      class="bg-white p-6 rounded shadow">

    @csrf

    <div class="mb-4">

        <label class="block mb-1 font-medium">
            Brand Name
        </label>

         <input type="text"
             name="name"
             value="{{ old('name') }}"
             class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

        @error('name')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div class="mb-4">

        <label class="block mb-1 font-medium">
            Description
        </label>

        <textarea name="description" rows="4" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description') }}</textarea>

        @error('description')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    <div class="mb-4">

        <label class="block mb-1 font-medium">
            Status
        </label>

        <select name="status" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            <option value="1"
                {{ old('status') == '1' ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('status') == '0' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

        @error('status')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">

        Save Brand

    </button>

</form>

@endsection