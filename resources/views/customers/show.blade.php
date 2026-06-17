@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-user-circle text-indigo-500"></i>
                    {{ $customer->name }}
                </h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-address-card text-indigo-400 text-sm"></i>
                    Complete customer profile with contact details and activity
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customers.edit', $customer->id) }}" 
                   class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-white transition hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                    <i class="fas fa-edit"></i>
                    Edit Customer
                </a>
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-white transition hover:bg-slate-800">
                    <i class="fas fa-arrow-left"></i>
                    Back to Customers
                </a>
            </div>
        </div>

        <div class="grid gap-8 xl:grid-cols-[380px_minmax(0,1fr)]">
            <!-- Left Column - Customer Profile -->
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-8 text-center">
                    <div class="relative inline-block">
                        <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto border-4 border-white/30">
                            <i class="fas fa-user text-5xl text-white"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1">
                            @if($customer->status)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500 px-2.5 py-1 text-xs font-bold text-white shadow-lg">
                                    <i class="fas fa-circle text-[6px]"></i>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-500 px-2.5 py-1 text-xs font-bold text-white shadow-lg">
                                    <i class="fas fa-circle text-[6px]"></i>
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-white mt-4">{{ $customer->name }}</h2>
                    <p class="text-indigo-200 text-sm mt-1 flex items-center justify-center gap-1">
                        <i class="fas fa-envelope text-xs"></i>
                        {{ $customer->email }}
                    </p>
                </div>

                <!-- Profile Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Phone Number</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $customer->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Address</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $customer->address ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Customer ID</p>
                                <p class="text-sm font-semibold text-slate-900">#{{ $customer->id }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Member Since</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $customer->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-3 text-center border border-indigo-200">
                            <p class="text-xs text-slate-500 font-medium">Orders</p>
                            <p class="text-xl font-bold text-indigo-700">{{ $customer->orders_count ?? 0 }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-3 text-center border border-emerald-200">
                            <p class="text-xs text-slate-500 font-medium">Total Spent</p>
                            <p class="text-xl font-bold text-emerald-700">{{ $setting->currency ?? 'PKR' }} {{ number_format($customer->total_spent ?? 0, 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Customer Activity & Info -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-info-circle text-indigo-500"></i>
                        Customer Information
                    </h2>
                    
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="fas fa-user text-indigo-400"></i>
                                Full Name
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $customer->name }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="fas fa-envelope text-indigo-400"></i>
                                Email Address
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $customer->email }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="fas fa-phone text-indigo-400"></i>
                                Phone Number
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $customer->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="fas fa-calendar-alt text-indigo-400"></i>
                                Last Updated
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $customer->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl bg-slate-50 p-4 border border-slate-200">
                        <p class="text-xs text-slate-500 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-indigo-400"></i>
                            Address
                        </p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $customer->address ?? 'No address provided' }}</p>
                    </div>
                </div>

                <!-- Recent Activity / Orders -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-clock text-indigo-500"></i>
                        Recent Activity
                    </h2>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                <i class="fas fa-user-plus text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">Account Created</p>
                                <p class="text-xs text-slate-500">{{ $customer->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <span class="text-xs text-slate-400">{{ $customer->created_at->diffForHumans() }}</span>
                        </div>

                        @if($customer->updated_at != $customer->created_at)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-edit text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">Profile Updated</p>
                                <p class="text-xs text-slate-500">{{ $customer->updated_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <span class="text-xs text-slate-400">{{ $customer->updated_at->diffForHumans() }}</span>
                        </div>
                        @endif

                        <!-- You can add more activity items here -->
                        <div class="text-center py-4">
                            <p class="text-sm text-slate-400">No recent orders or activity to display</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-slate-900 flex items-center gap-2 mb-4">
                        <i class="fas fa-bolt text-indigo-500"></i>
                        Quick Actions
                    </h2>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('customers.edit', $customer->id) }}" 
                           class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-50 px-4 py-3 text-indigo-700 hover:bg-indigo-100 transition-all duration-300 border border-indigo-200">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        <a href="{{ route('customers.index') }}" 
                           class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 transition-all duration-300 border border-slate-200">
                            <i class="fas fa-list"></i>
                            All Customers
                        </a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="col-span-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-red-50 px-4 py-3 text-red-600 hover:bg-red-100 transition-all duration-300 border border-red-200"
                                    onclick="return confirm('Are you sure you want to delete this customer?')">
                                <i class="fas fa-trash-alt"></i>
                                Delete Customer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
    
    /* Smooth hover effects */
    .hover\:scale-\[1\.02\] {
        transition: transform 0.3s ease;
    }
    .hover\:scale-\[1\.02\]:hover {
        transform: scale(1.02);
    }
    
    /* Gradient backgrounds for cards */
    .bg-gradient-to-br {
        background-size: 200% 200%;
        transition: background-position 0.5s ease;
    }
    .bg-gradient-to-br:hover {
        background-position: right center;
    }
    
    /* Profile avatar pulse animation */
    .relative.inline-block {
        animation: fadeInUp 0.6s ease;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Status badge animation */
    .fa-circle {
        animation: pulse-dot 2s ease-in-out infinite;
    }
    
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Hover effect on stat cards */
    .grid-cols-2 .bg-gradient-to-br {
        transition: all 0.3s ease;
    }
    .grid-cols-2 .bg-gradient-to-br:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endpush