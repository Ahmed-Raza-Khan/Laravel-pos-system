@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-4 py-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-indigo-500"></i>
                    Role Permissions
                </h2>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fa-solid fa-key text-indigo-400 text-sm"></i>
                    Manage permissions for <span class="font-semibold text-indigo-600">{{ $role->name }}</span> role
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-white transition hover:bg-slate-800">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Users
                </a>
            </div>
        </div>

        <form action="{{ route('roles.permissions.update', $role) }}" method="POST"
            class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-key text-indigo-500"></i>
                            Manage Role Permissions
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            <i class="fa-solid fa-info-circle text-indigo-400"></i>
                            These permissions will be inherited by all users with this role
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500">Role:</span>
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-700">
                            <i class="fa-solid fa-user-tag"></i>
                            {{ $role->name }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Role Info -->
                <div class="mb-6 bg-blue-50 rounded-xl p-4 border border-blue-200 flex items-start gap-3">
                    <i class="fa-solid fa-info-circle text-blue-500 text-xl mt-0.5"></i>
                    <div>
                        <p class="text-sm text-blue-800 font-semibold">Role Information</p>
                        <p class="text-xs text-blue-600 mt-1">
                            Users with this role will automatically get these permissions.
                            Changes here will affect all users assigned to this role.
                        </p>
                    </div>
                </div>

                <!-- Permission Groups -->
                @php
                    $permissionGroups = [
                        'Dashboard' => ['view dashboard'],
                        'Sales' => ['manage sales'],
                        'Products' => ['manage products', 'manage categories', 'manage brands'],
                        'Customers' => ['manage customers', 'manage suppliers'],
                        'Purchases' => ['manage purchases'],
                        'Inventory' => ['manage inventory', 'manage warehouses'],
                        'Reports' => ['manage reports'],
                        'Settings' => ['manage settings', 'manage users'],
                    ];
                @endphp

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($permissionGroups as $groupName => $permissions)
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-4 border border-slate-200">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-folder-open text-indigo-400"></i>
                                {{ $groupName }}
                            </h4>
                            <div class="space-y-2">
                                @foreach ($permissions as $permissionName)
                                    @php
                                        $hasPermission = $role->hasPermissionTo($permissionName);
                                    @endphp
                                    <label
                                        class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/50 transition cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="{{ $permissionName }}"
                                            {{ $hasPermission ? 'checked' : '' }}
                                            class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition">
                                        <span class="text-sm text-slate-700 group-hover:text-slate-900">
                                            {{ str_replace(' ', '', ucwords(str_replace('_', ' ', $permissionName))) }}
                                        </span>
                                        @if ($hasPermission)
                                            <span class="ml-auto text-xs text-emerald-600">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- All Permissions (Advanced) -->
                <div class="mt-6">
                    <details class="group">
                        <summary
                            class="flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer hover:text-indigo-600 transition">
                            <i class="fa-solid fa-chevron-right group-open:rotate-90 transition-transform"></i>
                            <i class="fa-solid fa-list-ul text-indigo-400"></i>
                            Show All Permissions (Advanced)
                        </summary>
                        <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach ($allPermissions as $permission)
                                    @php
                                        $hasPermission = $role->hasPermissionTo($permission->name);
                                    @endphp
                                    <label
                                        class="flex items-center gap-2 p-1.5 rounded hover:bg-white/50 transition cursor-pointer text-xs">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            {{ $hasPermission ? 'checked' : '' }}
                                            class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition">
                                        <span class="text-slate-700">{{ str_replace('_', ' ', $permission->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </details>
                </div>

                <!-- Current Permissions Summary -->
                <div class="mt-6 p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                    <h5 class="text-sm font-semibold text-indigo-800 flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-list-check"></i>
                        Current Role Permissions
                    </h5>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse($role->permissions as $permission)
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-medium rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200">
                                <i class="fa-solid fa-check-circle text-[8px]"></i>
                                {{ str_replace(' ', '', ucwords(str_replace('_', ' ', $permission->name))) }}
                            </span>
                        @empty
                            <span class="text-sm text-slate-500">No permissions assigned to this role</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-2.5 text-slate-700 hover:bg-slate-100 transition border border-slate-300">
                    <i class="fa-solid fa-times"></i>
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-2.5 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                    <i class="fa-solid fa-save"></i>
                    Update Role Permissions
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        summary {
            list-style: none;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        .hover\:scale-\[1\.02\] {
            transition: transform 0.3s ease;
        }

        .hover\:scale-\[1\.02\]:hover {
            transform: scale(1.02);
        }

        .group-open\:rotate-90 {
            transition: transform 0.3s ease;
        }

        details[open] .fa-chevron-right {
            transform: rotate(90deg);
        }

        input[type="checkbox"] {
            cursor: pointer;
        }
    </style>
@endpush
