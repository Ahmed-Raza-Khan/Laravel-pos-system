<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Show role permission management
     */
    public function editRolePermissions(Role $role)
    {
        $allPermissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('permissions.role', compact('role', 'allPermissions', 'rolePermissions'));
    }

    /**
     * Update role permissions
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.permissions', $role)
            ->with('success', 'Role permissions updated successfully.');
    }
}