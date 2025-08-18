<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
{
    /**
     * Display a listing of the states.
     */
    public function index()
    {
        $states = State::with('country')->latest()->get();
        return view('admin.locations.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new state.
     */


    /**
     * Store a newly created state in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        State::create([
            'name'       => $request->name,
            'country_id' => $request->country_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('states.index')->with('success', 'State created successfully.');
    }

    /**
     * Show the form for editing the specified state.
     */

    /**
     * Update the specified state in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $state = State::findOrFail($id);
        $state->update([
            'name'       => $request->name,
            'country_id' => $request->country_id,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('states.index')->with('success', 'State updated successfully.');
    }

    /**
     * Remove the specified state from storage.
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $state->delete();

        return redirect()->route('states.index')->with('success', 'State deleted successfully.');
    }
    public function getStatesByCountry($country_id)
    {
        return response()->json(
            State::where('country_id', $country_id)->get()
        );
    }
}
