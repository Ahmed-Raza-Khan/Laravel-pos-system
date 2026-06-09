<aside class="w-full h-full p-6 flex flex-col overflow-hidden">
    <section class="mb-8 flex-shrink-0 flex items-center justify-center gap-3">
        <div class="text-white">
            <i class="fas fa-box text-2xl"></i>
        </div>
        <a href="{{ auth()->user()?->can('view dashboard') ? route('dashboard') : (auth()->user()?->can('manage sales') ? route('sales.index') : url('/')) }}" class="block text-2xl font-bold tracking-tight text-white sidebar-label overflow-hidden">
            POS
        </a>
    </section>

    <nav class="space-y-1 text-sm font-medium flex-1 overflow-y-auto sidebar-scroll">
        @php
            $items = [
                ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-chart-line', 'permission' => 'view dashboard'],
                ['route' => 'categories.index', 'label' => 'Categories', 'icon' => 'fa-list', 'permission' => 'manage categories'],
                ['route' => 'brands.index', 'label' => 'Brands', 'icon' => 'fa-tag', 'permission' => 'manage brands'],
                ['route' => 'products.index', 'label' => 'Products', 'icon' => 'fa-box', 'permission' => 'manage products'],
                ['route' => 'warehouses.index', 'label' => 'Warehouses', 'icon' => 'fa-warehouse', 'permission' => 'manage warehouses'],
                ['route' => 'suppliers.index', 'label' => 'Suppliers', 'icon' => 'fa-truck', 'permission' => 'manage suppliers'],
                ['route' => 'customers.index', 'label' => 'Customers', 'icon' => 'fa-users', 'permission' => 'manage customers'],
                ['route' => 'purchases.index', 'label' => 'Purchases', 'icon' => 'fa-shopping-cart', 'permission' => 'manage purchases'],
                ['route' => 'sales.index', 'label' => 'Sales', 'icon' => 'fa-cash-register', 'permission' => 'manage sales'],
                ['route' => 'inventory.index', 'label' => 'Inventory', 'icon' => 'fa-industry', 'permission' => 'manage inventory'],
                ['route' => 'reports.index', 'label' => 'Reports', 'icon' => 'fa-chart-bar', 'permission' => 'manage reports'],
                ['route' => 'settings.index', 'label' => 'Settings', 'icon' => 'fa-cog', 'permission' => 'manage settings'],
                ['route' => 'users.index', 'label' => 'Users', 'icon' => 'fa-user-tie', 'permission' => 'manage users'],
            ];
        @endphp

        @foreach ($items as $item)
            @can($item['permission'])
                @php
                    $isActive = request()->routeIs($item['route'])
                        || request()->routeIs(str_replace('.index', '.*', $item['route']))
                        || ($item['route'] === 'reports.index' && request()->routeIs('reports.*'));
                @endphp
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-lg px-4 py-2.5 transition whitespace-nowrap group {{ $isActive ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}" title="{{ $item['label'] }}">
                    <i class="fas {{ $item['icon'] }} w-5 text-center flex-shrink-0"></i>
                    <span class="sidebar-label flex-1 overflow-hidden text-ellipsis transition-opacity duration-300">{{ $item['label'] }}</span>
                    @if($isActive)
                        <span class="sidebar-label inline-flex h-2 w-2 rounded-full bg-emerald-400 flex-shrink-0"></span>
                    @endif
                </a>
            @endcan
        @endforeach
    </nav>
</aside>
