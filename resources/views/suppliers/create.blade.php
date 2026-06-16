@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 py-6">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            @include('partials.back-button', ['href' => route('suppliers.index')])

            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-truck-field text-orange-500"></i>
                    Create Supplier
                </h2>

                <p class="text-slate-500 mt-1">
                    Add supplier details and assign warehouses.
                </p>
            </div>
        </div>

        {{-- Form Card --}}
        <form action="{{ route('suppliers.store') }}" method="POST"
            class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Supplier Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-user mr-2 text-slate-400"></i>
                        Supplier Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter supplier name"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Company --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-building mr-2 text-slate-400"></i>
                        Company
                    </label>
                    <input type="text" name="company" value="{{ old('company') }}" placeholder="Company name"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-phone mr-2 text-slate-400"></i>
                        Phone Number
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="03XX XXXXXXX"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-toggle-on mr-2 text-slate-400"></i>
                        Status
                    </label>

                    <select name="status"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">
                        <option value="1" {{ old('status', 1) == '1' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                {{-- Warehouses --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-warehouse mr-2 text-slate-400"></i>
                        Warehouses
                    </label>

                    <select name="warehouses[]" id="warehouseSelect" multiple>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}"
                                {{ collect(old('warehouses'))->contains($warehouse->id) ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-xs text-slate-500 mt-2">
                        Select one or more warehouses for this supplier.
                    </p>
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-location-dot mr-2 text-slate-400"></i>
                        Address
                    </label>

                    <textarea name="address" rows="4" placeholder="Supplier address..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address') }}</textarea>
                </div>

            </div>

            {{-- Submit --}}
            <div class="flex justify-end mt-8">
                <button type="submit" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl font-semibold shadow">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Supplier
                </button>
            </div>
        </form>
    </div>

    {{-- Tom Select --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#warehouseSelect', {
                plugins: ['remove_button'],
                create: false,
                placeholder: 'Select warehouses...',
                maxOptions: null
            });
        });
    </script>
@endsection
