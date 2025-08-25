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
            'admin_user_id' => 'nullable|exists:users,id',
        ]);

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
            'admin_user_id' => 'nullable|exists:users,id',
        ]);

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
}
