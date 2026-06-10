@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-2 sm:px-4">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-warehouse text-slate-700"></i> Warehouses
            </h2>
            <p class="text-slate-500 mt-1">
                Manage warehouse locations, performance tracks, and real-time product stocks.
            </p>
        </div>

        <a href="{{ route('warehouses.create') }}"
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-medium px-5 py-3 rounded-xl shadow-sm transition-all duration-200 group transform active:scale-95">
            <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i> Add Warehouse
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="relative max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by name, code or location..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-0 text-sm placeholder-slate-400 transition-colors">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-4">Warehouse Details</th>
                        <th class="text-left px-6 py-4">Code</th>
                        <th class="text-left px-6 py-4">Contact Phone</th>
                        <th class="text-left px-6 py-4">Status</th>
                        <th class="text-center px-6 py-4">Live Inventory</th>
                        <th class="text-right px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($warehouses as $warehouse)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 group-hover:bg-slate-900 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-building-user"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-slate-900 block">{{ $warehouse->name }}</span>
                                    <span class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                        <i class="fa-solid fa-location-dot"></i> Primary Storage
                                    </span>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 font-mono font-medium text-slate-600">
                            <span class="bg-slate-100 px-2 py-1 rounded-md text-xs border border-slate-200/60">{{ $warehouse->code }}</span>
                        </td>
                        
                        <td class="px-6 py-4 text-slate-600">
                            @if($warehouse->phone)
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-phone text-xs text-slate-400"></i> {{ $warehouse->phone }}</span>
                            @else
                                <span class="text-slate-400 italic text-xs">No phone added</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($warehouse->status)
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 px-3 py-1 rounded-full text-xs font-medium border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactive
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('warehouses.show', $warehouse->id) }}" 
                               class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-medium px-3 py-1.5 rounded-xl text-xs transition-all border border-blue-100 shadow-sm">
                                <i class="fa-solid fa-boxes-stacked"></i> View Stock ({{ $warehouse->products_count ?? $warehouse->products()->count() }})
                            </a>
                        </td>
                        
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('warehouses.edit', $warehouse->id) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white transition-all shadow-sm"
                                   title="Edit Warehouse">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>

                                <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this warehouse? All stock ties might break.')" 
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-500 hover:text-white transition-all shadow-sm"
                                            title="Delete Warehouse">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fa-solid fa-folder-open text-3xl text-slate-300"></i>
                                <div>
                                    <p class="font-medium text-slate-500 text-base">No warehouses found</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Try adjusting your search query or add a new location structure.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-5">
        {{ $warehouses->links() }}
    </div>
</div>
@endsection