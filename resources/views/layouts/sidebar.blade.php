<aside class="w-full h-full p-6">
    <div class="mb-10">
        <a href="{{ route('dashboard') }}" class="block text-3xl font-bold tracking-tight text-white">
            Laravel POS
        </a>
        <p class="mt-2 text-sm text-slate-400 max-w-[220px]">
            Modern inventory and sales management for your store.
        </p>
    </div>

    <nav class="space-y-2 text-sm font-medium">
        @php
            $items = [
                ['route' => 'dashboard', 'label' => 'Dashboard'],
                ['route' => 'categories.index', 'label' => 'Categories'],
                ['route' => 'brands.index', 'label' => 'Brands'],
                ['route' => 'products.index', 'label' => 'Products'],
                ['route' => 'suppliers.index', 'label' => 'Suppliers'],
                ['route' => 'customers.index', 'label' => 'Customers'],
                ['route' => 'purchases.index', 'label' => 'Purchases'],
                ['route' => 'sales.index', 'label' => 'Sales'],
                ['route' => 'inventory.index', 'label' => 'Inventory'],
            ];
        @endphp

        @foreach ($items as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center justify-between rounded-3xl px-4 py-3 transition
                    {{ request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                <span>{{ $item['label'] }}</span>
                @if(request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route'])))
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                @endif
            </a>
        @endforeach
    </nav>
</aside>
