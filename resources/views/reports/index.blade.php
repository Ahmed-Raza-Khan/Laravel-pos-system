@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Reports</h1>
            <p class="text-gray-500 mt-1">Business intelligence from your POS data</p>
        </div>

        @include('reports.partials.nav')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('reports.sales') }}" class="block bg-gradient-to-br from-blue-50 to-white rounded-3xl shadow-lg p-8 border border-blue-100 hover:shadow-xl transition">
                <h2 class="text-xl font-bold text-slate-900">Sales Reports</h2>
                <p class="text-slate-500 text-sm mt-2">Daily & monthly sales, payment methods, profit</p>
                <span class="inline-flex mt-4 text-sm font-semibold text-indigo-600">View report →</span>
            </a>
            <a href="{{ route('reports.purchases') }}" class="block bg-gradient-to-br from-orange-50 to-white rounded-3xl shadow-lg p-8 border border-orange-100 hover:shadow-xl transition">
                <h2 class="text-xl font-bold text-slate-900">Purchase Report</h2>
                <p class="text-slate-500 text-sm mt-2">Supplier purchases, stock received, totals</p>
                <span class="inline-flex mt-4 text-sm font-semibold text-indigo-600">View report →</span>
            </a>
            <a href="{{ route('reports.stock') }}" class="block bg-gradient-to-br from-green-50 to-white rounded-3xl shadow-lg p-8 border border-green-100 hover:shadow-xl transition">
                <h2 class="text-xl font-bold text-slate-900">Stock Report</h2>
                <p class="text-slate-500 text-sm mt-2">Current stock, low/out of stock, valuation</p>
                <span class="inline-flex mt-4 text-sm font-semibold text-indigo-600">View report →</span>
            </a>
            <a href="{{ route('reports.profit-loss') }}" class="block bg-gradient-to-br from-indigo-50 to-white rounded-3xl shadow-lg p-8 border border-indigo-100 hover:shadow-xl transition">
                <h2 class="text-xl font-bold text-slate-900">Profit / Loss</h2>
                <p class="text-slate-500 text-sm mt-2">Revenue vs purchase cost on sold items</p>
                <span class="inline-flex mt-4 text-sm font-semibold text-indigo-600">View report →</span>
            </a>
            <a href="{{ route('reports.customers') }}" class="block bg-gradient-to-br from-purple-50 to-white rounded-3xl shadow-lg p-8 border border-purple-100 hover:shadow-xl transition">
                <h2 class="text-xl font-bold text-slate-900">Customer Report</h2>
                <p class="text-slate-500 text-sm mt-2">Purchases, dues, top customers, recent orders</p>
                <span class="inline-flex mt-4 text-sm font-semibold text-indigo-600">View report →</span>
            </a>
            <a href="{{ route('reports.suppliers') }}" class="block bg-gradient-to-br from-pink-50 to-white rounded-3xl shadow-lg p-8 border border-pink-100 hover:shadow-xl transition">
                <h2 class="text-xl font-bold text-slate-900">Supplier Report</h2>
                <p class="text-slate-500 text-sm mt-2">Purchase history, supplied products, totals</p>
                <span class="inline-flex mt-4 text-sm font-semibold text-indigo-600">View report →</span>
            </a>
        </div>
    </div>
@endsection
