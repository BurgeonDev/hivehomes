<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the service providers.
     */
    public function index(Request $request)
    {
        // Load societies for the dropdown if super-admin
        $isSuperAdmin = $request->user()->hasRole('super_admin');
        $allSocieties = $isSuperAdmin
            ? Society::all()
            : collect();

        // Build the base query
        $query = ServiceProvider::query();

        if ($isSuperAdmin) {
            // If they picked a society in the dropdown, filter it:
            if ($request->filled('society_id')) {
                $query->where('society_id', $request->input('society_id'));
            }
            // else no where() → returns all
        } else {
            // Non-super-admin → force their own society
            $query->where('society_id', $request->user()->society_id);
        }

        $providers = $query->orderBy('created_at', 'desc')->get();

        return view('admin.service_providers.index', compact('providers', 'allSocieties'));
    }


    /**
     * Store a newly created service provider.
     */
    public function store(Request $request)
    {
        // 1. Base validation (no boolean rule on is_approved)
        $rules = [
            'name'            => 'required|string|max:255',
            'type'            => 'required|string|max:100',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:255',
            'cnic'            => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'bio'             => 'nullable|string',
            'profile_image'   => 'nullable|image|max:2048',
        ];

        // Only super-admin must supply society_id
        if ($request->user()->hasRole('super_admin')) {
            $rules['society_id'] = 'required|exists:societies,id';
        }

        $data = $request->validate($rules);

        // 2. Force society for non-super-admins
        if (! $request->user()->hasRole('super_admin')) {
            $data['society_id'] = $request->user()->society_id;
        }

        // 3. Normalize the approved checkbox
        $data['is_approved'] = $request->boolean('is_approved', false);

        // 4. Handle image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/service_providers');
            $data['profile_image'] = Str::replaceFirst('public/', 'storage/', $path);
        }

        ServiceProvider::create($data);

        return redirect()
            ->route('admin.service-providers.index')
            ->with('success', 'Service Provider added successfully.');
    }

    public function update(Request $request, ServiceProvider $service_provider)
    {
        // 1. Base validation
        $rules = [
            'name'            => 'required|string|max:255',
            'type'            => 'required|string|max:100',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:255',
            'cnic'            => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'bio'             => 'nullable|string',
            'profile_image'   => 'nullable|image|max:2048',
        ];

        // **Use the correct role name** for super_admin
        if ($request->user()->hasRole('super_admin')) {
            $rules['society_id'] = 'required|exists:societies,id';
        }

        $data = $request->validate($rules);

        // 2. Force society for non–super admins (same role check)
        if (! $request->user()->hasRole('super_admin')) {
            $data['society_id'] = $request->user()->society_id;
        }

        // 3. Normalize the approved checkbox
        $data['is_approved'] = $request->boolean('is_approved', false);

        // 4. Handle image replacement (unchanged)
        if ($request->hasFile('profile_image')) {
            if ($service_provider->profile_image) {
                $old = Str::replaceFirst('storage/', 'public/', $service_provider->profile_image);
                Storage::delete($old);
            }
            $path = $request->file('profile_image')->store('public/service_providers');
            $data['profile_image'] = Str::replaceFirst('public/', 'storage/', $path);
        }

        // 5. Perform the update
        $service_provider->update($data);

        return redirect()
            ->route('admin.service-providers.index')
            ->with('success', 'Service Provider updated successfully.');
    }


    /**
     * Remove the specified service provider.
     */
    public function destroy(ServiceProvider $service_provider)
    {
        // delete profile image file
        if ($service_provider->profile_image) {
            $oldPath = Str::replaceFirst('storage/', 'public/', $service_provider->profile_image);
            Storage::delete($oldPath);
        }

        $service_provider->delete();

        return redirect()
            ->route('admin.service-providers.index')
            ->with('success', 'Service Provider deleted.');
    }
}
