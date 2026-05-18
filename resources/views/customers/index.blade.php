@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Customers</h2>
        <p class="text-slate-500 mt-1">Manage customer information and contact details</p>
    </div>

    <a href="{{ route('customers.create') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-2xl shadow-sm transition mt-4 sm:mt-0">
        Add Customer
    </a>
</div>

@include('partials.index-toolbar', ['placeholder' => 'Search customers...'])

<div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
    <div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="bg-white text-black text-left">
                <th class="px-6 py-4 font-semibold">ID</th>
                <th class="px-6 py-4 font-semibold">Name</th>
                <th class="px-6 py-4 font-semibold">Email</th>
                <th class="px-6 py-4 font-semibold">Phone</th>
                <th class="px-6 py-4 font-semibold">Status</th>
                <th class="px-6 py-4 font-semibold text-right">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
            @forelse($customers as $customer)
                <tr class="hover:bg-cyan-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $customer->id }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $customer->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $customer->email }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $customer->phone }}</td>

                    <td class="px-6 py-4">
                        @if($customer->status)
                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Active</span>
                        @else
                            <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-bold text-slate-700">Inactive</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('customers.edit', $customer->id) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                ✎ Edit
                            </a>

                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                    🗑 Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500 font-medium">
                        👥 No customers found. Start adding customers!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<div class="mt-4">
    {{ $customers->links() }}
</div>

@endsection