@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-2 sm:px-4">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-arrow-right-arrow-left text-slate-700"></i> Stock Distribution & Transfers
            </h2>
            <p class="text-slate-500 mt-1">Move components safely between Primary, Karachi, and Lahore setups</p>
        </div>

        <a href="{{ route('inventory.index') }}"
            class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2.5 rounded-xl shadow-sm border border-slate-200 transition-all text-sm w-full sm:w-auto transform active:scale-95">
            <i class="fa-solid fa-arrow-left text-slate-400"></i> Back to Inventory
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
        <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-gears text-lime-600 text-sm"></i> Execute Stock Action
        </h3>
        
        <form method="POST" action="{{ route('inventory.transfer.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Select Product</label>
                    <select id="productSelect" name="product_id" class="w-full" required>
                        <option value="">Choose a product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                {{ (old('product_id', request('product_id')) == $product->id) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">From Warehouse (Source)</label>
                    <select name="from_warehouse_id" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:border-slate-400 focus:ring-0" required>
                        <option value="">Select Source...</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}"
                                {{ (old('from_warehouse_id', request('from_warehouse_id')) == $wh->id) ? 'selected' : '' }}>
                                {{ $wh->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">To Warehouse (Destination)</label>
                    <select name="to_warehouse_id" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:border-slate-400 focus:ring-0" required>
                        <option value="">Select Destination...</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}" {{ old('to_warehouse_id') == $wh->id ? 'selected' : '' }}>
                                {{ $wh->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Quantity</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" placeholder="Enter Qty" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:border-slate-400 focus:ring-0" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Action Type</label>
                    <select name="type" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:border-slate-400 focus:ring-0" required>
                        <option value="transfer" {{ old('type') === 'transfer' ? 'selected' : '' }}>Standard Transfer</option>
                        <option value="return" {{ old('type') === 'return' ? 'selected' : '' }}>Stock Return</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-2.5 px-5 rounded-xl text-sm transition-colors shadow-sm flex items-center justify-center gap-2 transform active:scale-95">
                        <i class="fa-solid fa-bolt text-amber-400 text-xs"></i> Execute Action
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-white">
            <h3 class="font-bold text-slate-900">Transfer & Return History Logs</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Timestamp</th>
                        <th class="px-6 py-4 text-left">Product</th>
                        <th class="px-6 py-4 text-left">Route</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-center">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($transfers as $log)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $log->product->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-rose-600 bg-rose-50 px-2 py-1 rounded-lg border border-rose-100 text-xs">{{ $log->fromWarehouse->name ?? 'N/A' }}</span> 
                            <i class="fa-solid fa-arrow-right text-slate-400 mx-1 text-xs"></i> 
                            <span class="font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100 text-xs">{{ $log->toWarehouse->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $log->type === 'transfer' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-purple-50 text-purple-700 border border-purple-100' }}">
                                {{ strtoupper($log->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-center text-slate-900">{{ $log->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-slate-400">
                            <i class="fa-solid fa-clock-rotate-left text-2xl mb-2 text-slate-300 block"></i>
                            No stock distribution logs found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#productSelect').select2({
            placeholder: 'Search & Select Product...',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
@endsection