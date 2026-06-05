@extends('layouts.app')

@section('content')
<div class="w-full mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">
                Warehouses
            </h2>
            <p class="text-slate-500">
                Manage warehouse locations
            </p>
        </div>

        <a href="{{ route('warehouses.create') }}"
           class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl">
            + Add Warehouse
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 border-b">
            <form method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search warehouse..." class="w-full md:w-80 rounded-lg border-slate-300">
            </form>
        </div>
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-6 py-4">Name</th>
                    <th class="text-left px-6 py-4">Code</th>
                    <th class="text-left px-6 py-4">Phone</th>
                    <th class="text-left px-6 py-4">Status</th>
                    <th class="text-right px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warehouses as $warehouse)
                <tr class="border-t">
                    <td class="px-6 py-4 font-medium">
                        {{ $warehouse->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $warehouse->code }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $warehouse->phone }}
                    </td>
                    <td class="px-6 py-4">
                        @if($warehouse->status)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                Active
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('warehouses.edit',$warehouse->id) }}" class="text-blue-600 mr-3">
                            Edit
                        </a>

                        <form action="{{ route('warehouses.destroy',$warehouse->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Delete warehouse?')" class="text-red-600">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10">
                        No warehouses found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $warehouses->links() }}
    </div>
</div>
@endsection