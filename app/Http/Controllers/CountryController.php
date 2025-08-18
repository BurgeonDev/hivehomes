<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('admin.locations.countries.index', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:countries,name',
        ]);

        Country::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Country added successfully!');
    }

    public function edit(Country $country)
    {
        return response()->json($country);
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|unique:countries,name,' . $country->id,
        ]);

        $country->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Country updated successfully!');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->back()->with('success', 'Country deleted successfully!');
    }
}
