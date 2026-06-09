@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-1 py-1">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">
                Inventory History
            </h2>

            <p class="text-slate-500 mt-1">
                Review inventory changes and stock movement over time.
            </p>
        </div>

        <a href="{{ route('inventory.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-white hover:bg-slate-800 transition">
            ← Back to Inventory
        </a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-white text-black">
                    <tr>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-left">Warehouse</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Quantity</th>
                        <th class="px-6 py-3 text-left">Before</th>
                        <th class="px-6 py-3 text-left">After</th>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Date</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($histories as $history)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $history->product?->name ?? 'Deleted Product' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $history->warehouse?->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-white text-xs
                                    @if ($history->type === 'purchase')
                                        bg-green-600
                                    @elseif ($history->type === 'sale')
                                        bg-red-600
                                    @else
                                        bg-blue-600
                                    @endif">
                                    {{ ucfirst($history->type) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $history->quantity }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $history->stock_before }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $history->stock_after }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $history->user?->name ?? 'System' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $history->created_at->format('d M Y h:i A') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                No inventory history found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    <div class="mt-6">
        {{ $histories->links() }}
    </div>

</div>
@endsection