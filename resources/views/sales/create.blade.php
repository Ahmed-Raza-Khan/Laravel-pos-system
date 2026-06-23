@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-1 py-1">
        <div class="flex items-center justify-between mb-4">
            @include('partials.back-button', ['href' => route('sales.index')])
            <div class="text-sm text-slate-500">Create Sale</div>
        </div>

        <div class="bg-white p-4 shadow rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="{{ route('sales.set-warehouse') }}" method="POST" id="warehouse-switcher-form" class="flex items-center gap-2">
                @csrf
                <label for="global_warehouse_id" class="text-sm font-bold text-gray-700 whitespace-nowrap">
                    Active Warehouse:
                </label>
                <select 
                    name="warehouse_id" 
                    id="global_warehouse_id" 
                    onchange="document.getElementById('warehouse-switcher-form').submit()"
                    class="rounded-lg border-gray-300 bg-white py-1.5 pl-3 pr-10 text-gray-900 font-medium shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" {{ session('selected_warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </form>
            
            <div class="text-xs text-amber-600 bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200">
                <strong>Notice:</strong> Switching warehouses will keep your cart items, but stock levels will be strictly re-validated upon submitting the sale.
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
                    <form method="GET" id="search-form" action="{{ route('sales.create') }}">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-400 z-10"></i>
                            <input 
                                type="text" 
                                name="search" 
                                id="product-search-input"
                                value="{{ request('search') }}"
                                placeholder="Search Product, SKU or Barcode..." 
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                autocomplete="off"
                            >
                            <div id="search-results" class="absolute z-50 w-full mt-1 bg-white rounded-xl shadow-lg border border-slate-200 hidden max-h-96 overflow-y-auto"></div>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="product-grid">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 product-card" data-product-id="{{ $product->id }}">
                            @if ($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                    class="w-full h-44 object-cover">
                            @endif

                            <div class="p-4">
                                <h3 class="font-bold text-slate-800 line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ $product->brand?->name }}
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-lg font-bold text-green-600">
                                        {{ number_format($product->sale_price,2) }}
                                    </span>
                                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-lg">
                                        {{ $product->current_warehouse_stock ?? 0 }} In Stock
                                    </span>
                                </div>

                                <form action="{{ route('sales.addToCart',$product->id) }}" method="POST" class="mt-4">
                                    @csrf

                                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-medium">
                                        <i class="fa-solid fa-cart-plus mr-2"></i>
                                        Add To Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            </div>

            <div>
                <div class="bg-white shadow rounded-xl overflow-hidden sticky top-5">
                    <div class="flex items-center justify-between px-4 py-4 border-b">
                        <h2 class="text-lg font-bold text-gray-800">
                            Cart
                        </h2>
                        <form method="POST" action="{{ route('sales.clearCart') }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-2xl transition">
                                Clear
                            </button>
                        </form>
                    </div>

                    @if($heldCarts->isNotEmpty())
                        <section class="px-4 py-3 border-b bg-amber-50">
                            @foreach($heldCarts as $held)
                                <form method="POST" action="{{ route('sales.resumeCart', $held->id) }}" class="flex justify-between gap-2 mb-2 text-sm">
                                    @csrf
                                    <span>{{ $held->reference }}</span>
                                    <button type="submit" class="text-xs bg-amber-600 text-white px-3 py-2 rounded-xl">Resume</button>
                                </form>
                            @endforeach
                        </section>
                    @endif
                    
                    <form method="POST" action="{{ route('sales.holdCart') }}" class="px-4 py-2 border-b flex gap-2">
                        @csrf
                        <input type="text" name="reference" placeholder="Hold label" class="flex-1 rounded border-slate-200 text-sm">
                        <button type="submit" class="bg-amber-400 text-white text-xs px-2 py-1 rounded">Hold</button>
                    </form>

                    <section class="p-4">
                        @php $subtotal = 0; @endphp
                        @forelse($cart as $item)
                            @php
                                $subtotal += $item['total'];
                            @endphp
                            <div class="border rounded-xl p-3 mb-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-semibold text-sm text-gray-800">
                                            {{ $item['name'] }}
                                        </h4>
                                        <p class="text-sm text-green-600 mt-1">
                                            {{ $setting->currency ?? 'PKR' }} {{ number_format($item['price'], 2) }}
                                        </p>
                                    </div>

                                    <form method="POST" action="{{ route('sales.removeCart', $item['product_id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700 text-sm">✕</button>
                                    </form>
                                </div>

                                <div class="mt-3">
                                    <form method="POST" action="{{ route('sales.updateCart', $item['product_id']) }}">
                                        @csrf
                                        <div class="flex gap-2">
                                            <input type="number" name="qty" min="1" value="{{ $item['qty'] }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                            <button class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 rounded-lg transition">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-3 text-sm font-semibold text-gray-700">
                                    Total:
                                    <span class="text-indigo-600">
                                        {{ $setting->currency ?? 'PKR' }} {{ number_format($item['total'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-8">
                                Cart is empty.
                            </div>
                        @endforelse

                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700">Subtotal</span>
                                <span class="text-lg font-bold text-indigo-600">
                                    {{ $setting->currency ?? 'PKR' }} {{ number_format($subtotal, 2) }}
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('sales.store') }}">
                            @csrf

                            <input type="hidden" name="warehouse_id" value="{{ session('selected_warehouse_id') }}">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                                    <select name="customer_id" class="select2 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                        <option value="">Walk-in Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ (old('customer_id', $checkoutMeta['customer_id'] ?? '') == $customer->id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                            <option value="">None</option>
                                            <option value="fixed">Fixed</option>
                                            <option value="percentage">Percentage</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                                        <input type="number" step="0.01" name="discount_value" id="discount_value" value="{{ old('discount_value', $checkoutMeta['discount_value'] ?? 0) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tax %</label>
                                    <input type="number" step="0.01" name="tax_percentage" id="tax_percentage" value="{{ old('tax_percentage', $checkoutMeta['tax_percentage'] ?? $setting->tax_percentage ?? 0) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>

                                <div class="bg-slate-100 rounded-xl p-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span>Subtotal</span>
                                        <span id="subtotal-preview">{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Discount</span>
                                        <span id="discount-preview">0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Tax</span>
                                        <span id="tax-preview">0.00</span>
                                    </div>
                                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-slate-900 rounded-2xl p-5">
                                        <div class="text-sm opacity-90">
                                            Grand Total
                                        </div>
                                        <div class="text-3xl font-bold mt-1" id="grand-total-preview">
                                            {{ number_format($subtotal,2) }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Change</span>
                                        <span id="change-preview">0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Due</span>
                                        <span id="due-preview">0.00</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Paid Amount</label>
                                    <input type="number" max="9999999999.99" step="0.01" name="paid_amount" id="paid_amount" value="{{ old('paid_amount', $checkoutMeta['paid_amount'] ?? '') }}" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                    <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="easypaisa">Easypaisa</option>
                                        <option value="jazzcash">JazzCash</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                                </div>

                                <button class="w-full bg-green-400 text-white py-4 rounded-2xl font-bold text-lg">
                                    <i class="fa-solid fa-circle-check mr-2"></i>
                                    @if(isset($checkoutMeta['editing_sale_id']))
                                        Update Sale
                                    @else
                                        Complete Sale
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                let searchTimeout;
                const searchInput = $('#product-search-input');
                const resultsContainer = $('#search-results');
                
                // Add to cart function using AJAX
                function addToCart(productId) {
                    // Show loading indicator
                    const $resultItem = $('.search-result-item[data-product-id="' + productId + '"]');
                    $resultItem.css('opacity', '0.5');
                    
                    $.ajax({
                        url: '{{ route("sales.addToCart", ":id") }}'.replace(':id', productId),
                        type: 'POST', // Changed from 'method' to 'type'
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Reload page to show updated cart
                            window.location.reload();
                        },
                        error: function(xhr) {
                            let errorMsg = 'Error adding product to cart.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            alert(errorMsg);
                            $resultItem.css('opacity', '1');
                        }
                    });
                }
                
                // Function to perform search
                function performSearch(query) {
                    if (query.length < 2) {
                        resultsContainer.addClass('hidden').empty();
                        return;
                    }
                    
                    // Show loading state
                    resultsContainer.html('<div class="p-4 text-center text-slate-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Searching...</div>');
                    resultsContainer.removeClass('hidden');
                    
                    $.ajax({
                        url: '{{ route("sales.search-products") }}',
                        type: 'GET',
                        data: {
                            search: query,
                            warehouse_id: '{{ session('selected_warehouse_id') }}'
                        },
                        success: function(data) {
                            resultsContainer.empty();
                            
                            if (data.length === 0) {
                                resultsContainer.html('<div class="p-4 text-center text-slate-500">No products found</div>');
                                return;
                            }
                            
                            // Build results with click handler
                            $.each(data, function(index, product) {
                                const productHtml = `
                                    <div class="flex items-center gap-3 p-3 hover:bg-indigo-50 border-b border-slate-100 last:border-0 transition cursor-pointer search-result-item" data-product-id="${product.id}">
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden">
                                            ${product.image ? `<img src="{{ asset('storage') }}/${product.image}" class="w-full h-full object-cover">` : `<i class="fa-solid fa-box text-slate-400 text-xl flex items-center justify-center w-full h-full"></i>`}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-slate-800 truncate">${product.name}</div>
                                            <div class="text-sm text-slate-500">SKU: ${product.sku || 'N/A'}</div>
                                            <div class="flex gap-3 mt-1 flex-wrap">
                                                <span class="text-xs font-medium text-green-600">Price: $${product.sale_price}</span>
                                                <span class="text-xs font-medium text-indigo-600">Stock: ${product.current_warehouse_stock || 0}</span>
                                            </div>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-slate-300"></i>
                                    </div>
                                `;
                                resultsContainer.append(productHtml);
                            });
                            
                            // Add click handler to each result
                            $('.search-result-item').on('click', function() {
                                const productId = $(this).data('product-id');
                                addToCart(productId);
                            });
                        },
                        error: function(xhr) {
                            console.error('Search error:', xhr.responseText);
                            resultsContainer.html('<div class="p-4 text-center text-red-500">Error searching products. Please try again.</div>');
                        }
                    });
                }
                
                // Handle input with debounce
                searchInput.on('input', function() {
                    clearTimeout(searchTimeout);
                    const query = $(this).val().trim();
                    
                    if (query.length < 2) {
                        resultsContainer.addClass('hidden').empty();
                        return;
                    }
                    
                    searchTimeout = setTimeout(function() {
                        performSearch(query);
                    }, 300);
                });
                
                // Show results when input gets focus (if there are results)
                searchInput.on('focus', function() {
                    if (resultsContainer.children().length > 0) {
                        resultsContainer.removeClass('hidden');
                    }
                });
                
                // Hide results when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#product-search-input, #search-results').length) {
                        resultsContainer.addClass('hidden');
                    }
                });
                
                // Handle Enter key - submit form
                searchInput.on('keydown', function(e) {
                    if (e.key === 'Enter') {
                        if (resultsContainer.children().length > 0 && !resultsContainer.hasClass('hidden')) {
                            e.preventDefault();
                        }
                    }
                });

                // Existing calculation functions
                const subtotal = {{ $subtotal }};
                const taxInput = document.getElementById('tax_percentage');
                const discountType = document.getElementById('discount_type');
                const discountValue = document.getElementById('discount_value');
                const paidAmount = document.getElementById('paid_amount');

                function calculate() {
                    let discount = 0;
                    if (discountType.value === 'fixed') {
                        discount = parseFloat(discountValue.value) || 0;
                    }
                    if (discountType.value === 'percentage') {
                        discount = subtotal * ((parseFloat(discountValue.value) || 0) / 100);
                    }

                    let afterDiscount = subtotal - discount;
                    let tax = afterDiscount * ((parseFloat(taxInput.value) || 0) / 100);
                    let grandTotal = afterDiscount + tax;
                    let paid = parseFloat(paidAmount.value) || 0;

                    let due = 0;
                    let change = 0;

                    if (paid >= grandTotal) {
                        change = paid - grandTotal;
                    } else {
                        due = grandTotal - paid;
                    }

                    document.getElementById('discount-preview').innerText = discount.toFixed(2);
                    document.getElementById('tax-preview').innerText = tax.toFixed(2);
                    document.getElementById('grand-total-preview').innerText = grandTotal.toFixed(2);
                    document.getElementById('due-preview').innerText = due.toFixed(2);
                    document.getElementById('change-preview').innerText = change.toFixed(2);
                }

                if (taxInput) taxInput.addEventListener('input', calculate);
                if (discountType) discountType.addEventListener('change', calculate);
                if (discountValue) discountValue.addEventListener('input', calculate);
                if (paidAmount) paidAmount.addEventListener('input', calculate);

                calculate();
            });
        </script>
    @endpush

    {{-- Add Select2 CSS and JS --}}
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
        <style>
            .select2-container--bootstrap-5 .select2-selection {
                min-height: 44px;
                border-radius: 0.75rem;
                border-color: #cbd5e1;
            }
            .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
                line-height: 44px;
                padding-left: 44px;
            }
            .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
                height: 44px;
            }
            .select2-container--bootstrap-5 .select2-dropdown {
                border-radius: 0.75rem;
                border-color: #cbd5e1;
            }
            .select2-container--bootstrap-5 .select2-results__option {
                padding: 8px 12px;
            }
            .select2-container--bootstrap-5 .select2-results__option--highlighted {
                background-color: #6366f1;
            }
            .select2-results__option .flex {
                display: flex;
            }
            .select2-results__option .items-center {
                align-items: center;
            }
            .select2-results__option .gap-3 {
                gap: 0.75rem;
            }
            .select2-results__option .p-2 {
                padding: 0.5rem;
            }
            #search-results {
            max-height: 400px;
            overflow-y: auto;
            }
            #search-results a {
                text-decoration: none;
                color: inherit;
            }
            #search-results a:hover {
                background-color: #f8fafc;
            }
            #search-results::-webkit-scrollbar {
                width: 6px;
            }
            #search-results::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }
            #search-results::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }
            #search-results::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
    @endpush
@endsection