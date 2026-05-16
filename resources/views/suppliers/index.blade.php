@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Suppliers</h2>
            <p class="text-slate-500 mt-1">Manage supplier information and contact details</p>
        </div>

        <a href="{{ route('suppliers.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl shadow-sm transition mt-4 sm:mt-0">
            ➕ Add Supplier
        </a>
    </div>

    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white text-black text-left">
                    <th class="px-6 py-4 font-semibold">ID</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Company</th>
                    <th class="px-6 py-4 font-semibold">Phone</th>
                    <th class="px-6 py-4 font-semibold">Address</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-orange-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $supplier->id }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $supplier->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $supplier->company ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $supplier->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $supplier->address ?? 'N/A' }}</td>

                        <td class="px-6 py-4">
                            @if($supplier->status)
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-bold text-slate-700">Inactive</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                    ✎ Edit
                                </a>

                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500 font-medium">
                            🏭 No suppliers found. Create one to manage your supply chain!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
@endsection
