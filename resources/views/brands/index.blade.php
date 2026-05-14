@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-bold">
            Brands
        </h2>

        <a href="{{ route('brands.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Brand
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Slug</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr class="border-t">
                        <td class="p-3">
                            {{ $brand->id }}
                        </td>
                        <td class="p-3">
                            {{ $brand->name }}
                        </td>
                        <td class="p-3">
                            {{ $brand->slug }}
                        </td>
                        <td class="p-3">
                            <span class="{{ $brand->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $brand->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="5" class="p-5 text-center text-gray-500">
                            No brands found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $brands->links() }}
    </div>
@endsection