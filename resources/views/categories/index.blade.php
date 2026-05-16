@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Categories</h2>
            <p class="text-sm text-slate-500">Manage product categories</p>
        </div>

        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-2xl">
            Add Category
        </a>
    </div>

    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-white text-black"
                <tr class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-left">
                    <th class="px-6 py-4 font-semibold">ID</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-emerald-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $category->id }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $category->name }}</td>
                        <td class="px-6 py-4">
                            @if($category->status)
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-bold text-slate-700">Inactive</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                    ✎ Edit
                                </a>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500 font-medium">
                            📁 No categories found. Create one to organize your products!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>        
    </div>
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection