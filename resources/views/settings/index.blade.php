@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Settings</h2>
            <p class="text-sm text-slate-500 mt-1">Configure store details, invoice settings, tax, currency, and branding.</p>
        </div>
    </div>

    {{-- @if(session('success'))
        <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif --}}

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-3xl shadow-lg">
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
@endsection
