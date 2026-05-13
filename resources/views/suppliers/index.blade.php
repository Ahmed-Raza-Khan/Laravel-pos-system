@extends('layouts.app')

@section('content')
    <div class="flex justify-between mb-5">
        <h2 class="text-2xl font-bold">Suppliers</h2>

        <a href="{{ route('suppliers.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Supplier
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Company</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Address</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($suppliers as $supplier)
                    <tr class="border-t">
                        <td class="p-3">{{ $supplier->id }}</td>
                        <td class="p-3">{{ $supplier->name }}</td>
                        <td class="p-3">{{ $supplier->company ?? 'N/A' }}</td>
                        <td class="p-3">{{ $supplier->phone ?? 'N/A' }}</td>
                        <td class="p-3">{{ $supplier->address ?? 'N/A' }}</td>

                        <td class="p-3">
                            <span class="{{ $supplier->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $supplier->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-gray-500">
                            No suppliers found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
@endsection
