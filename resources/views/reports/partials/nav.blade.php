@php
    $links = [
        ['route' => 'reports.index', 'label' => 'Overview'],
        ['route' => 'reports.sales', 'label' => 'Sales'],
        ['route' => 'reports.purchases', 'label' => 'Purchases'],
        ['route' => 'reports.stock', 'label' => 'Stock'],
        ['route' => 'reports.profit-loss', 'label' => 'Profit / Loss'],
        ['route' => 'reports.customers', 'label' => 'Customers'],
        ['route' => 'reports.suppliers', 'label' => 'Suppliers'],
    ];
@endphp

<div class="flex flex-wrap gap-2 mb-8">
    @foreach ($links as $link)
        <a href="{{ route($link['route']) }}"
           class="px-4 py-2 rounded-2xl text-sm font-semibold transition
                {{ request()->routeIs($link['route']) ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            {{ $link['label'] }}
        </a>
    @endforeach
</div>
