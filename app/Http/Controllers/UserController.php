<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // Super Admin sees all users; Society Admin & Members see only their own society’s users
        if (auth()->user()->hasRole('super_admin')) {
            $users = User::with('roles', 'society')->get();
        } else {
            $users = User::with('roles', 'society')
                ->where('society_id', auth()->user()->society_id)
                ->get();
        }

        // Super Admin sees all roles; others only “member”
        if (auth()->user()->hasRole('super_admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where('name', 'member')->get();
        }

        // Societies for Super Admin only (for the create form)
        $societies = auth()->user()->hasRole('super_admin')
            ? Society::all()
            : collect();

        return view('admin.users.index', compact('users', 'roles', 'societies'));
    }




    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required',
            'phone'    => 'nullable|string|max:20',
            'profile_pic' => 'nullable|image|max:2048',
            'status'   => 'required|in:active,inactive',
            'society_id'  => 'required|exists:societies,id',
        ]);

        if ($request->hasFile('profile_pic')) {
            $data['profile_pic'] = $request->file('profile_pic')
                ->store('users', 'public');
        }

        $data['password']   = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $id,
            'password'     => 'nullable|min:6|confirmed',
            'role'         => 'required',
            'phone'        => 'nullable|string|max:20',
            'profile_pic'  => 'nullable|image|max:2048',
            'status'       => 'required|in:active,inactive',
            'society_id'  => 'required|exists:societies,id',
        ]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        // remove password fields so 'fill' won’t try to set them
        unset($data['password'], $data['password_confirmation']);

        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic) {
                Storage::disk('public')->delete($user->profile_pic);
            }
            $data['profile_pic'] = $request->file('profile_pic')
                ->store('users', 'public');
        }

        $user->fill($data)->save();
        $user->syncRoles([$data['role']]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
