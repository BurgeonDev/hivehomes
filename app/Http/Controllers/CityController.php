<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Traits\AdminRoleCheck;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use AdminRoleCheck;


    public function index()
    {
        $this->authorizeSuperAdmin();
        $cities = City::with('state.country')->get();
        return view('admin.locations.cities.index', compact('cities'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();
        $states = State::with('country')->get();
        return view('admin.locations.cities.create', compact('states'));
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
        ]);

        City::create($request->only('name', 'state_id'));

        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        $this->authorizeSuperAdmin();
        $states = State::with('country')->get();
        return view('admin.locations.cities.edit', compact('city', 'states'));
    }

    public function update(Request $request, City $city)
    {
        $this->authorizeSuperAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
        ]);

        $city->update($request->only('name', 'state_id'));

        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $this->authorizeSuperAdmin();
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }

    // Accessible to all users (no admin check)
    public function getCitiesByState($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}
