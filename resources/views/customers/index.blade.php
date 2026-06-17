@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                <i class="fas fa-users text-indigo-500"></i>
                Customers
            </h2>
            <p class="text-slate-500 mt-1 flex items-center gap-2">
                <i class="fas fa-address-book text-indigo-400 text-sm"></i>
                Manage customer information and contact details
            </p>
        </div>

        <a href="{{ route('customers.create') }}" 
           class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
            <i class="fas fa-user-plus"></i>
            Add Customer
        </a>
    </div>

    @include('partials.index-toolbar', ['placeholder' => 'Search customers...'])

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <i class="fas fa-hashtag text-indigo-400 mr-1"></i>
                            ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <i class="fas fa-user text-indigo-400 mr-1"></i>
                            Customer
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <i class="fas fa-envelope text-indigo-400 mr-1"></i>
                            Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <i class="fas fa-phone text-indigo-400 mr-1"></i>
                            Phone
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <i class="fas fa-toggle-on text-indigo-400 mr-1"></i>
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <i class="fas fa-cog text-indigo-400 mr-1"></i>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-indigo-50/50 transition-all duration-200 group">
                            <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 rounded-full text-xs font-bold text-slate-700">
                                    {{ $customer->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $customer->name }}</p>
                                        @if($customer->address)
                                            <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                                <i class="fas fa-map-pin text-[10px]"></i>
                                                {{ Str::limit($customer->address, 30) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                                    <i class="fas fa-envelope text-xs text-slate-400"></i>
                                    {{ $customer->email }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                                    <i class="fas fa-phone text-xs text-slate-400"></i>
                                    {{ $customer->phone ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($customer->status)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                        <i class="fas fa-circle text-[6px] text-emerald-500"></i>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700">
                                        <i class="fas fa-circle text-[6px] text-slate-500"></i>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- <a href="{{ route('customers.show', $customer->id) }}" 
                                       class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 group-hover:scale-105">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a> --}}
                                    <a href="{{ route('customers.edit', $customer->id) }}" 
                                       class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 group-hover:scale-105">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" 
                                          style="display:inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 group-hover:scale-105">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-3xl text-slate-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-700 mb-1">No Customers Found</h3>
                                    <p class="text-sm text-slate-500">Start adding customers to build your client base</p>
                                    <a href="{{ route('customers.create') }}" 
                                       class="mt-4 inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-sm text-white hover:bg-indigo-700 transition-colors">
                                        <i class="fas fa-user-plus"></i>
                                        Add Customer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-slate-500">
            Showing <span class="font-semibold text-slate-700">{{ $customers->firstItem() ?? 0 }}</span> 
            to <span class="font-semibold text-slate-700">{{ $customers->lastItem() ?? 0 }}</span> 
            of <span class="font-semibold text-slate-700">{{ $customers->total() }}</span> customers
        </p>
        {{ $customers->links() }}
    </div>
@endsection

@push('styles')
<style>
    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
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
    
    .group {
        transition: all 0.3s ease;
    }
    .group:hover {
        transform: translateX(4px);
    }
    
    .fa-circle {
        animation: pulse-dot 2s ease-in-out infinite;
    }
    
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
@endpush