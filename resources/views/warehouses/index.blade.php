@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-2 sm:px-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-warehouse text-indigo-600"></i> Warehouses
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fa-solid fa-building text-indigo-400 text-sm"></i>
                    Manage warehouse locations, suppliers, and real-time product stocks
                </p>
            </div>

            <a href="{{ route('warehouses.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300 flex-shrink-0">
                <i class="fa-solid fa-plus-circle"></i> Add Warehouse
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-slate-100">
                <form method="GET" class="relative max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, code or location..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 text-sm placeholder-slate-400 transition-all duration-300">
                </form>
            </div>

            <!-- Responsive Table without horizontal scroll -->
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4">
                    @forelse($warehouses as $warehouse)
                        <!-- Card View for Mobile/Tablet -->
                        <div
                            class="bg-white rounded-2xl border border-slate-200 p-4 hover:shadow-lg transition-all duration-300 hover:border-indigo-300">
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                <!-- Warehouse Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                            <i class="fa-solid fa-building-user"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span
                                                    class="font-semibold text-slate-900 truncate">{{ $warehouse->name }}</span>
                                                @if ($warehouse->status)
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full text-[10px] font-medium border border-emerald-200 flex-shrink-0">
                                                        <span
                                                            class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full text-[10px] font-medium border border-rose-200 flex-shrink-0">
                                                        <span class="w-1 h-1 rounded-full bg-rose-400"></span>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                                <i class="fa-solid fa-location-dot text-[10px]"></i>
                                                {{ Str::limit($warehouse->address ?? 'Primary Storage', 40) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Code & Contact -->
                                <div class="flex flex-wrap items-center gap-3 md:gap-4">
                                    <div>
                                        <span class="text-xs text-slate-500 me-2">Warehouse ID</span>
                                        <span
                                            class="inline-flex items-center gap-1 bg-slate-100 px-2.5 py-1 rounded-full text-xs font-mono font-medium border border-slate-200 block mt-0.5 me-2">
                                            <i class="fa-solid fa-tag text-slate-400 text-[10px]"></i>
                                            {{ $warehouse->code }}
                                        </span>
                                    </div>
                                    @if ($warehouse->phone)
                                        <div>
                                            <span class="text-xs text-slate-500">Contact</span>
                                            <span class="flex items-center gap-1 text-slate-600 text-sm mt-0.5">
                                                <i class="fa-solid fa-phone text-xs text-indigo-400"></i>
                                                {{ $warehouse->phone }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Suppliers -->
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs text-slate-500 block mb-1">Suppliers</span>
                                    @php
                                        $supplierCount = $warehouse->suppliers->count();
                                        $displaySuppliers = $warehouse->suppliers->take(2);
                                        $remainingCount = $supplierCount - 2;
                                    @endphp

                                    @if ($supplierCount > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($displaySuppliers as $supplier)
                                                <span
                                                    class="inline-flex items-center gap-1 bg-indigo-50 border border-indigo-200 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-medium truncate max-w-[100px]">
                                                    <i class="fa-solid fa-user-tie text-[8px] flex-shrink-0"></i>
                                                    {{ Str::limit($supplier->name, 10) }}
                                                </span>
                                            @endforeach

                                            @if ($remainingCount > 0)
                                                <span
                                                    class="inline-flex items-center justify-center bg-slate-200 border border-slate-300 text-slate-700 text-[10px] px-2 py-0.5 rounded-full font-medium hover:bg-indigo-500 hover:text-white hover:border-indigo-500 transition-all cursor-pointer relative group/supplier">
                                                    <i class="fa-solid fa-plus-circle text-[8px] mr-0.5"></i>
                                                    +{{ $remainingCount }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No suppliers</span>
                                    @endif
                                </div>

                                <!-- Operations -->
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('warehouses.show', $warehouse->id) }}"
                                        class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white font-medium px-3 py-1.5 rounded-xl text-xs transition-all border border-indigo-200 shadow-sm whitespace-nowrap">
                                        <i class="fa-solid fa-boxes-stacked"></i>
                                        {{ $warehouse->products_count ?? $warehouse->products()->count() }}
                                    </a>

                                    @can('manage inventory')
                                        <a href="{{ route('inventory.transfer.create', ['from_warehouse_id' => $warehouse->id]) }}"
                                            class="inline-flex items-center gap-1 bg-slate-50 text-slate-700 hover:bg-slate-900 hover:text-white font-medium px-3 py-1.5 rounded-xl text-xs transition-all border border-slate-200 shadow-sm whitespace-nowrap">
                                            <i class="fa-solid fa-arrow-right-arrow-left"></i> Transfer
                                        </a>
                                    @endcan
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <a href="{{ route('warehouses.show', $warehouse->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300"
                                        title="View Warehouse">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    <a href="{{ route('warehouses.edit', $warehouse->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300"
                                        title="Edit Warehouse">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            onclick="return confirm('Are you sure you want to delete this warehouse? All stock ties might break.')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300"
                                            title="Delete Warehouse">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-4">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center">
                                    <i class="fa-solid fa-warehouse text-3xl text-slate-400"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-600 text-base">No warehouses found</p>
                                    <p class="text-sm text-slate-400 mt-0.5">Try adjusting your search query or add a new
                                        location</p>
                                </div>
                                <a href="{{ route('warehouses.create') }}"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-sm text-white hover:bg-indigo-700 transition-colors">
                                    <i class="fa-solid fa-plus-circle"></i>
                                    Add Warehouse
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500 text-center sm:text-left">
                Showing <span class="font-semibold text-slate-700">{{ $warehouses->firstItem() ?? 0 }}</span>
                to <span class="font-semibold text-slate-700">{{ $warehouses->lastItem() ?? 0 }}</span>
                of <span class="font-semibold text-slate-700">{{ $warehouses->total() }}</span> warehouses
            </p>
            {{ $warehouses->links() }}
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Pagination Styles */
        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            color: #475569;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: white;
        }

        .pagination .page-link:hover {
            border-color: #6366f1;
            color: #6366f1;
            transform: scale(1.05);
        }

        .pagination .active .page-link {
            background: #6366f1;
            border-color: #6366f1;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination .page-link i {
            font-size: 0.75rem;
        }

        /* Card hover effects */
        .hover\:shadow-lg {
            transition: all 0.3s ease;
        }

        .hover\:shadow-lg:hover {
            transform: translateY(-2px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid-cols-1 {
                grid-template-columns: 1fr;
            }

            .md\:flex-row {
                flex-direction: column;
                align-items: stretch;
            }

            .md\:items-center {
                align-items: stretch;
            }

            .gap-4 {
                gap: 1rem;
            }

            .flex-wrap {
                flex-wrap: wrap;
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-1 {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
