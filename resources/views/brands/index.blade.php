@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Brands</h2>
            <p class="text-sm text-slate-500">Manage product brands</p>
        </div>

        <a href="{{ route('brands.create') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-2xl">
            Add Brand
        </a>
    </div>

    @include('partials.index-toolbar', ['placeholder' => 'Search brands...'])

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-lg overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-white text-black">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">ID</th>
                    <th class="px-6 py-4 text-left font-semibold">Name</th>
                    <th class="px-6 py-4 text-left font-semibold">Slug</th>
                    <th class="px-6 py-4 text-left font-semibold">Status</th>
                    <th class="px-6 py-4 text-right font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($brands as $brand)
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $brand->id }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            {{ $brand->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $brand->slug }}
                        </td>
                        <td class="px-6 py-4">
                            @if($brand->status)
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-bold text-slate-700">Inactive</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                    ✎ Edit
                                </a>

                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">
                            🏷️ No brands found. Create one to categorize your products!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $brands->links() }}
    </div>
@endsection