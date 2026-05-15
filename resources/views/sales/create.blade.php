@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Products Section -->
            <div class="lg:col-span-2">
                <!-- Search -->
                <div class="bg-white shadow rounded-xl p-4 mb-6">
                    <form method="GET">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search Product / SKU / Barcode"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </form>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        <div class="bg-white shadow rounded-xl overflow-hidden hover:shadow-lg transition">
                            <div class="p-4">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-full h-40 object-cover rounded-lg mb-3">
                                @endif
                                <h3 class="font-semibold text-gray-800 text-sm mb-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-green-600 font-bold mb-1">
                                    PKR {{ number_format($product->sale_price, 2) }}
                                </p>
                                <p class="text-xs text-gray-500 mb-3">
                                    Stock: {{ $product->stock }}
                                </p>
                                <form method="POST" action="{{ route('sales.addToCart', $product->id) }}">
                                    @csrf
                                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg transition">
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

            <!-- Cart Section -->
            <div>
                <div class="bg-white shadow rounded-xl overflow-hidden sticky top-5">
                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-4 border-b">
                        <h2 class="text-lg font-bold text-gray-800">
                            Cart
                        </h2>
                        <form method="POST" action="{{ route('sales.clearCart') }}">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-lg transition">
                                Clear
                            </button>
                        </form>
                    </div>

                    <!-- Body -->
                    <div class="p-4">
                        @php
                            $subtotal = 0;
                        @endphp
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
                                            PKR {{ number_format($item['price'], 2) }}
                                        </p>
                                    </div>

                                    <form method="POST" action="{{ route('sales.removeCart', $item['product_id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700 text-sm">
                                            ✕
                                        </button>
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
                                        PKR {{ number_format($item['total'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-8">
                                Cart is empty.
                            </div>
                        @endforelse

                        <!-- Subtotal -->
                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700">
                                    Subtotal
                                </span>
                                <span class="text-lg font-bold text-indigo-600">
                                    PKR {{ number_format($subtotal, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Form -->
                        <form method="POST" action="{{ route('sales.store') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Customer
                                    </label>
                                    <select name="customer_id"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                        <option value="">
                                            Walk-in Customer
                                        </option>

                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Discount Type
                                        </label>
                                        <select name="discount_type"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                            <option value="">
                                                None
                                            </option>
                                            <option value="fixed">
                                                Fixed
                                            </option>
                                            <option value="percentage">
                                                Percentage
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Discount Value
                                        </label>
                                        <input type="number" step="0.01" name="discount_value" value="0"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tax %
                                    </label>
                                    <input type="number" step="0.01" name="tax_percentage" value="0"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Paid Amount
                                    </label>
                                    <input type="number" step="0.01" name="paid_amount" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Payment Method
                                    </label>
                                    <select name="payment_method"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="easypaisa">Easypaisa</option>
                                        <option value="jazzcash">JazzCash</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Notes
                                    </label>
                                    <textarea name="notes" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                                </div>

                                <button
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                                    Complete Sale
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
