<aside class="w-full h-full p-6">
    <section class="mb-10">
        <a href="{{ auth()->user()?->can('view dashboard') ? route('dashboard') : (auth()->user()?->can('manage sales') ? route('sales.index') : url('/')) }}" class="block text-3xl font-bold tracking-tight text-white">
            Laravel POS
        </a>
        <p class="mt-2 text-sm text-slate-400 max-w-[220px]">
            Modern inventory and sales management for your store.
        </p>
    </section>

    <nav class="space-y-2 text-sm font-medium">
        @php
            $items = [
                ['route' => 'dashboard', 'label' => 'Dashboard', 'permission' => 'view dashboard'],
                ['route' => 'categories.index', 'label' => 'Categories', 'permission' => 'manage categories'],
                ['route' => 'brands.index', 'label' => 'Brands', 'permission' => 'manage brands'],
                ['route' => 'products.index', 'label' => 'Products', 'permission' => 'manage products'],
                ['route' => 'suppliers.index', 'label' => 'Suppliers', 'permission' => 'manage suppliers'],
                ['route' => 'customers.index', 'label' => 'Customers', 'permission' => 'manage customers'],
                ['route' => 'purchases.index', 'label' => 'Purchases', 'permission' => 'manage purchases'],
                ['route' => 'sales.index', 'label' => 'Sales', 'permission' => 'manage sales'],
                ['route' => 'inventory.index', 'label' => 'Inventory', 'permission' => 'manage inventory'],
                ['route' => 'reports.index', 'label' => 'Reports', 'permission' => 'manage reports'],
                ['route' => 'settings.index', 'label' => 'Settings', 'permission' => 'manage settings'],
                ['route' => 'users.index', 'label' => 'Users', 'permission' => 'manage users'],
            ];
        @endphp

        @foreach ($items as $item)
            @can($item['permission'])
                @php
                    $isActive = request()->routeIs($item['route'])
                        || request()->routeIs(str_replace('.index', '.*', $item['route']))
                        || ($item['route'] === 'reports.index' && request()->routeIs('reports.*'));
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center justify-between rounded-3xl px-4 py-3 transition
                        {{ $isActive ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span>{{ $item['label'] }}</span>
                    @if($isActive)
                        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                    @endif
                </a>
            @endcan
        @endforeach
    </nav>
</aside>
