<aside class="w-64 bg-neutral-700 text-white h-full p-5">
    <h1 class="text-3xl font-bold mb-8 text-mauve-400">
        <a href="{{ route('dashboard')}}">
            Laravel POS
        </a>
    </h1>

    <ul class="space-y-3">
        <li class="bg-neutral-600 rounded-lg p-2 text-[18px]">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('categories.index') }}">
                Categories
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('brands.index') }}">
                Brands
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('products.index') }}">
                Products
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('suppliers.index') }}">
                Suppliers
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('customers.index') }}">
                Customers
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('purchases.index') }}">
                Purchases
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('sales.index') }}">
                Sales
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="{{ route('inventory.index') }}">
                Inventory
            </a>
        </li>
        <li class="bg-neutral-600 rounded-md p-2 text-[18px]">
            <a href="#">
                POS
            </a>
        </li>
    </ul>
</aside>
