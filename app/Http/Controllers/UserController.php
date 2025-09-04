<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Society;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            $users = User::with('roles', 'society.city.state.country')->get();

            $activeUsersCount = User::where('is_active', 'active')->count();
            $inactiveUsersCount = User::where('is_active', 'inactive')->count();

            $roles = Role::all();
            $societies = Society::all();

            $countries = Country::all();
            $cities = City::all();
        } else {
            $users = User::with('roles', 'society.city.state.country')
                ->where('society_id', $user->society_id)
                ->get();

            $activeUsersCount = User::where('is_active', 'active')
                ->where('society_id', $user->society_id)
                ->count();

            $inactiveUsersCount = User::where('is_active', 'inactive')
                ->where('society_id', $user->society_id)
                ->count();

            $roles = Role::where('name', 'member')->get();
            $societies = collect();

            $countries = Country::where('id', $user->country_id)->get();
            $states = State::where('id', $user->country_id)->get();
            $cities = City::where('state_id', $user->state_id)->get();
        }


        return view('admin.users.index', compact(
            'users',
            'roles',
            'societies',
            'activeUsersCount',
            'inactiveUsersCount',
            'countries',
            'cities',

        ));
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
            'is_active'   => 'required|in:active,inactive',
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
            'is_active'       => 'required|in:active,inactive',
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

        // Check roles before deleting
        if ($user->hasRole('super_admin') || $user->hasRole('society_admin')) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete a Super Admin or Society Admin.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
