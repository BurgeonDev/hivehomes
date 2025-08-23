<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProviderType;
use Illuminate\Http\Request;

class ServiceProviderTypeController extends Controller
{
    public function index()
    {
        $types = ServiceProviderType::all();
        return view('admin.types.index', compact('types'));
    }



    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        ServiceProviderType::create($request->all());

        return redirect()->route('admin.types.index')->with('success', 'Type added.');
    }

    public function edit(ServiceProviderType $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    public function update(Request $request, ServiceProviderType $type)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $type->update($request->all());

        return redirect()->route('admin.types.index')->with('success', 'Type updated.');
    }

    public function destroy(ServiceProviderType $type)
    {
        $type->delete();
        return back()->with('success', 'Type deleted.');
    }
}
