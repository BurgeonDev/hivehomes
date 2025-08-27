<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;

class SocietyController extends Controller
{
    public function index()
    {
        $societies = Society::with(['city', 'state', 'country', 'admin'])->get();
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $admins = User::role('society_admin')->get();

        return view('admin.societies.index', compact('societies', 'cities', 'states', 'countries', 'admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'admin_user_id' => 'nullable|exists:users,id',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Society::create($validated);

        return redirect()->route('societies.index')->with('success', 'Society created.');
    }

    public function update(Request $request, Society $society)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'admin_user_id' => 'nullable|exists:users,id',
        ]);
        if ($request->hasFile('logo')) {
            if ($society->logo && \Storage::disk('public')->exists($society->logo)) {
                \Storage::disk('public')->delete($society->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $society->update($validated);

        return redirect()->route('societies.index')->with('success', 'Society updated.');
    }

    public function destroy(Society $society)
    {
        $society->delete();

        return redirect()->route('societies.index')->with('success', 'Society deleted.');
    }
    public function getSocietiesByCity($city_id)
    {
        $societies = Society::where('city_id', $city_id)->get();
        return response()->json($societies);
    }
    public function updateStatus(Request $request, Society $society)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $society->is_active = $request->status;
        $society->save();

        return response()->json([
            'success' => true,
            'message' => 'Society status updated successfully.',
            'status' => $society->is_active
        ]);
    }
}
