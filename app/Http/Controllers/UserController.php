<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Support\IndexTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = IndexTable::apply(User::with('roles', 'permissions'), ['name', 'email'], 'name', 10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->pluck('name');

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name');

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function showPermissions(User $user)
    {
        $allPermissions = Permission::orderBy('name')->get();
        
        // Get role-based permissions
        $rolePermissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        
        // Get direct permissions
        $directPermissions = $user->permissions->pluck('name')->toArray();
        
        // Merge both for display
        $allUserPermissions = array_unique(array_merge($rolePermissions, $directPermissions));
        
        return view('users.permissions', compact('user', 'allPermissions', 'allUserPermissions', 'directPermissions', 'rolePermissions'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        // This updates ONLY direct permissions (model_has_permissions)
        // It does NOT affect role-based permissions (role_has_permissions)
        $user->syncPermissions($request->permissions ?? []);
        
        // Refresh the user
        $user->refresh();

        // Get updated permissions
        $directPermissions = $user->permissions->pluck('name')->toArray();
        $rolePermissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        $allPermissions = array_unique(array_merge($directPermissions, $rolePermissions));

        return redirect()->route('users.permissions', $user)
            ->with('success', 'Permissions updated successfully. User now has ' . count($directPermissions) . ' direct permissions and ' . count($rolePermissions) . ' role-based permissions.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}