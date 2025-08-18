<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles          = Role::withCount('users')->get();
        $allPermissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'allPermissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return back()->with('success', 'Role created successfully.');
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::findById($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return back()->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy($id)
    {
        $role = Role::findById($id);

        // Prevent deleting super-admin role
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Cannot delete super-admin role.');
        }

        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
}
