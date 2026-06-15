@extends('layouts.app')

@section('content')

<div class="w-full mx-auto px-4 py-6 space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-4xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-chart-line text-indigo-600"></i>
            Reports
        </h1>
        <p class="text-slate-500 mt-2">
            Business intelligence from your POS data
        </p>
    </div>

    {{-- Nav --}}
    @include('reports.partials.nav')

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Sales --}}
        <a href="{{ route('reports.sales') }}"
           class="group bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300">

            <div class="flex items-center justify-between">
                <i class="fa-solid fa-chart-column text-blue-600 text-2xl"></i>
                <span class="text-xs text-blue-500 font-semibold opacity-0 group-hover:opacity-100 transition">
                    Open →
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mt-4 flex items-center gap-2">
                Sales Reports
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Daily & monthly sales, payment methods, profit
            </p>
        </a>

        {{-- Purchases --}}
        <a href="{{ route('reports.purchases') }}"
           class="group bg-gradient-to-br from-orange-50 to-white border border-orange-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">

            <div class="flex items-center justify-between">
                <i class="fa-solid fa-truck text-orange-500 text-2xl"></i>
                <span class="text-xs text-orange-500 font-semibold opacity-0 group-hover:opacity-100 transition">
                    Open →
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mt-4">
                Purchase Report
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Supplier purchases, stock received, totals
            </p>
        </a>

        {{-- Stock --}}
        <a href="{{ route('reports.stock') }}"
           class="group bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">

            <div class="flex items-center justify-between">
                <i class="fa-solid fa-boxes-stacked text-green-600 text-2xl"></i>
                <span class="text-xs text-green-500 font-semibold opacity-0 group-hover:opacity-100 transition">
                    Open →
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mt-4">
                Stock Report
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Current stock, low/out of stock, valuation
            </p>
        </a>

        {{-- Profit/Loss --}}
        <a href="{{ route('reports.profit-loss') }}"
           class="group bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">

            <div class="flex items-center justify-between">
                <i class="fa-solid fa-scale-balanced text-indigo-600 text-2xl"></i>
                <span class="text-xs text-indigo-500 font-semibold opacity-0 group-hover:opacity-100 transition">
                    Open →
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mt-4">
                Profit / Loss
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Revenue vs purchase cost on sold items
            </p>
        </a>

        {{-- Customers --}}
        <a href="{{ route('reports.customers') }}"
           class="group bg-gradient-to-br from-purple-50 to-white border border-purple-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">

            <div class="flex items-center justify-between">
                <i class="fa-solid fa-user-group text-purple-600 text-2xl"></i>
                <span class="text-xs text-purple-500 font-semibold opacity-0 group-hover:opacity-100 transition">
                    Open →
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mt-4">
                Customer Report
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Purchases, dues, top customers, recent orders
            </p>
        </a>

        {{-- Suppliers --}}
        <a href="{{ route('reports.suppliers') }}"
           class="group bg-gradient-to-br from-pink-50 to-white border border-pink-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">

            <div class="flex items-center justify-between">
                <i class="fa-solid fa-handshake text-pink-600 text-2xl"></i>
                <span class="text-xs text-pink-500 font-semibold opacity-0 group-hover:opacity-100 transition">
                    Open →
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mt-4">
                Supplier Report
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Purchase history, supplied products, totals
            </p>
        </a>

    </div>
</div>

@endsection