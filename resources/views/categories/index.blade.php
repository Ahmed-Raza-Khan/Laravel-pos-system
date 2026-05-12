@extends('layouts.app')

@section('content')
    <div class="flex justify-between mb-5">
        <h2 class="text-2xl font-bold">
            Categories
        </h2>

        <a href="{{ route('categories.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Category
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">

        <table class="w-full">

            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($categories as $category)

                <tr class="border-t">
                    <td class="p-3">{{ $category->id }}</td>
                    <td class="p-3">{{ $category->name }}</td>
                    <td class="p-3">
                        <span class="{{ $category->status ? 'text-green-600' : 'text-red-600' }}">
                            {{ $category->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="p-3">
                        <div class="flex gap-2">

                            <a href="{{ route('categories.edit', $category->id) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}"
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
                    <td colspan="4" class="p-5 text-center text-gray-500">
                        No categories found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>

@endsection