@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-gear text-slate-700"></i>
                Settings
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Configure store details, invoice settings, tax, currency, and branding.
            </p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white shadow-xl rounded-3xl p-6 space-y-10">

        @csrf

        {{-- STORE INFO --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-store text-indigo-500"></i>
                    Store Information
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Basic store settings for invoices and contact info.
                </p>
            </div>

            <div class="md:col-span-2 grid gap-4">

                <div>
                    <label class="flex items-center gap-2 font-medium mb-1">
                        <i class="fa-solid fa-signature text-slate-500"></i> Store Name
                    </label>
                    <input type="text" name="store_name"
                        value="{{ old('store_name', $setting->store_name) }}"
                        class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    @error('store_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 font-medium mb-1">
                        <i class="fa-solid fa-location-dot text-slate-500"></i> Store Address
                    </label>
                    <textarea name="store_address" rows="3"
                        class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('store_address', $setting->store_address) }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="flex items-center gap-2 font-medium mb-1">
                            <i class="fa-solid fa-envelope text-slate-500"></i> Email
                        </label>
                        <input type="email" name="contact_email"
                            value="{{ old('contact_email', $setting->contact_email) }}"
                            class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 font-medium mb-1">
                            <i class="fa-solid fa-phone text-slate-500"></i> Phone
                        </label>
                        <input type="text" name="contact_phone"
                            value="{{ old('contact_phone', $setting->contact_phone) }}"
                            class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

            </div>
        </div>

        {{-- FINANCIAL --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-coins text-emerald-500"></i>
                    Finance Settings
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Tax, currency & invoice configuration.
                </p>
            </div>

            <div class="md:col-span-2 grid gap-4">

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label class="flex items-center gap-2 font-medium mb-1">
                            <i class="fa-solid fa-percent text-slate-500"></i> Tax %
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" name="tax_percentage"
                                value="{{ old('tax_percentage', $setting->tax_percentage) }}"
                                class="w-full border rounded-xl px-3 py-2 pr-10 focus:ring-2 focus:ring-indigo-500">
                            <span class="absolute right-3 top-2.5 text-slate-400">%</span>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 font-medium mb-1">
                            <i class="fa-solid fa-dollar-sign text-slate-500"></i> Currency
                        </label>
                        <input type="text" name="currency"
                            value="{{ old('currency', $setting->currency) }}"
                            class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>

                </div>

                <div>
                    <label class="flex items-center gap-2 font-medium mb-1">
                        <i class="fa-solid fa-receipt text-slate-500"></i> Invoice Prefix
                    </label>
                    <input type="text" name="invoice_prefix"
                        value="{{ old('invoice_prefix', $setting->invoice_prefix) }}"
                        class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="flex items-center gap-2 font-medium mb-1">
                        <i class="fa-solid fa-file-lines text-slate-500"></i> Invoice Footer
                    </label>
                    <textarea name="invoice_footer" rows="3"
                        class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('invoice_footer', $setting->invoice_footer) }}</textarea>
                </div>

            </div>
        </div>

        {{-- BRANDING --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-palette text-pink-500"></i>
                    Branding
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Upload invoice logo & branding assets.
                </p>
            </div>

            <div class="md:col-span-2 space-y-4">

                <div>
                    <label class="flex items-center gap-2 font-medium mb-1">
                        <i class="fa-solid fa-image text-slate-500"></i> Invoice Logo
                    </label>
                    <input type="file" name="invoice_logo" accept="image/*"
                        class="w-full border rounded-xl px-3 py-2">
                </div>

                @if($setting->invoice_logo)
                <div class="p-4 border rounded-2xl bg-slate-50">
                    <p class="text-sm text-slate-500 mb-2">Current Logo</p>
                    <img src="{{ asset('storage/' . $setting->invoice_logo) }}"
                        class="h-20 object-contain">
                </div>
                @endif

            </div>
        </div>

        {{-- TERMS --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-file-contract text-blue-500"></i>
                    Invoice Terms
                </h3>
            </div>

            <div class="md:col-span-2">
                <textarea name="invoice_terms" rows="5"
                    class="w-full border rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">{{ old('invoice_terms', $setting->invoice_terms) }}</textarea>
            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end">
            <button type="submit"
                class="flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl">
                <i class="fa-solid fa-floppy-disk"></i>
                Save Settings
            </button>
        </div>

    </form>
</div>
@endsection

{{-- @extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Settings</h2>
            <p class="text-sm text-slate-500 mt-1">Configure store details, invoice settings, tax, currency, and branding.</p>
        </div>
    </div> --}}

    {{-- @if(session('success'))
        <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif --}}

    {{-- <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-3xl shadow-lg">
        @csrf

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-3">
                <h3 class="text-xl font-semibold text-slate-900">Store Information</h3>
                <p class="text-sm text-slate-500">Basic store settings for invoices and contact information.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Store Name</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('store_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Store Address</label>
                    <textarea name="store_address" rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('store_address', $setting->store_address) }}</textarea>
                    @error('store_address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-1 font-medium">Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $setting->contact_email) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('contact_email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('contact_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-3">
                <h3 class="text-xl font-semibold text-slate-900">Invoice & Financial Settings</h3>
                <p class="text-sm text-slate-500">Tax, currency, invoice prefix, and footer text.</p>
            </div>

            <div class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-1 font-medium">Tax Percentage</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="tax_percentage" value="{{ old('tax_percentage', $setting->tax_percentage) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 pr-10 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500">%</span>
                        </div>
                        @error('tax_percentage')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $setting->currency) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('currency')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Invoice Prefix</label>
                    <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $setting->invoice_prefix) }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('invoice_prefix')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Invoice Footer</label>
                    <textarea name="invoice_footer" rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('invoice_footer', $setting->invoice_footer) }}</textarea>
                    @error('invoice_footer')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-3">
                <h3 class="text-xl font-semibold text-slate-900">Branding</h3>
                <p class="text-sm text-slate-500">Upload the logo that appears on printable invoices.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Invoice Logo</label>
                    <input type="file" name="invoice_logo" accept="image/*" class="w-full text-slate-700 border border-slate-200 rounded-lg px-3 py-2 focus:outline-none">
                    @error('invoice_logo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                @if($setting->invoice_logo)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm text-slate-500 mb-3">Current logo preview</p>
                        <img src="{{ asset('storage/' . $setting->invoice_logo) }}" alt="Invoice logo" class="h-24 object-contain">
                    </div>
                @endif
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-3">
                <h3 class="text-xl font-semibold text-slate-900">Invoice Terms</h3>
                <p class="text-sm text-slate-500">Add default terms and conditions for printed invoices.</p>
            </div>

            <div>
                <textarea name="invoice_terms" rows="5" class="w-full border border-slate-200 rounded-3xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('invoice_terms', $setting->invoice_terms) }}</textarea>
                @error('invoice_terms')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl">Save Settings</button>
    </form>
@endsection --}}
