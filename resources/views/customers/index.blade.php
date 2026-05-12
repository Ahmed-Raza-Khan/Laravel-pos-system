@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-5">
    <h2 class="text-2xl font-bold">Customers</h2>

    <a href="{{ route('customers.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
        Add Customer
    </a>
</div>

<div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($customers as $customer)
                <tr class="border-t">
                    <td class="p-3">{{ $customer->id }}</td>
                    <td class="p-3">{{ $customer->name }}</td>
                    <td class="p-3">{{ $customer->email }}</td>
                    <td class="p-3">{{ $customer->phone }}</td>

                    <td class="p-3">
                        <span class="{{ $customer->status ? 'text-green-600' : 'text-red-600' }}">
                            {{ $customer->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="p-3">
                        <div class="flex gap-2">

                            <a href="{{ route('customers.edit', $customer->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="{{ route('customers.destroy', $customer->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-5 text-center text-gray-500">
                        No customers found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $customers->links() }}
</div>

@endsection