@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-2xl font-bold">
            Purchases
        </h2>

        <p class="text-gray-500 text-sm">
            Manage all purchase records
        </p>
    </div>

    <a href="{{ route('purchases.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
        Add Purchase
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full">

            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-4">#</th>
                    <th class="p-4">Invoice</th>
                    <th class="p-4">Supplier</th>
                    <th class="p-4">Purchase Date</th>
                    <th class="p-4">Total Amount</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($purchases as $purchase)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-4">
                            {{ $purchase->id }}
                        </td>

                        <td class="p-4 font-semibold text-blue-600">
                            {{ $purchase->invoice_no }}
                        </td>

                        <td class="p-4">
                            {{ $purchase->supplier->name ?? 'N/A' }}
                        </td>

                        <td class="p-4">
                            {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
                        </td>

                        <td class="p-4 font-semibold">
                            Rs. {{ number_format($purchase->total_amount, 2) }}
                        </td>

                        <td class="p-4">
                            @if($purchase->status == 1)
                                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                                    Active
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('purchases.edit', $purchase->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('purchases.destroy', $purchase->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this purchase?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                                        Delete
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center p-6 text-gray-500">
                            No purchases found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

<div class="mt-5">
    {{ $purchases->links() }}
</div>

@endsection