<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderType;
use App\Models\Society;
use App\Traits\AdminRoleCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceProviderController extends Controller
{
    use AdminRoleCheck;

    public function __construct()
    {
        $this->authorizeAdminRoles(); // 👈 both roles allowed
    }
    /**
     * Display a listing of the service providers.
     */
    public function index(Request $request)
    {
        $isSuperAdmin = $request->user()->hasRole('super_admin');

        $allSocieties = $isSuperAdmin ? Society::all() : collect();

        // Base query
        $query = ServiceProvider::query();

        if ($isSuperAdmin) {
            // Super admin can filter by society_id
            if ($request->filled('society_id')) {
                $query->where('society_id', $request->input('society_id'));
            }
            // Counts for ALL societies (unfiltered)
            $countQuery = ServiceProvider::query();
        } else {
            // Normal user → only their society
            $query->where('society_id', $request->user()->society_id);

            // Counts also only for their society
            $countQuery = ServiceProvider::where('society_id', $request->user()->society_id);
        }

        // Counts
        $activeCount     = (clone $countQuery)->where('is_active', true)->count();
        $inactiveCount   = (clone $countQuery)->where('is_active', false)->count();
        $approvedCount   = (clone $countQuery)->where('is_approved', true)->count();
        $unapprovedCount = (clone $countQuery)->where('is_approved', false)->count();

        $providers = $query->orderBy('created_at', 'desc')->get();
        $types     = ServiceProviderType::all();

        return view('admin.service_providers.index', compact(
            'providers',
            'allSocieties',
            'types',
            'activeCount',
            'inactiveCount',
            'approvedCount',
            'unapprovedCount'
        ));
    }




    /**
     * Store a newly created service provider.
     */


    public function store(Request $request)
    {
        // 1. Base validation
        $rules = [
            'name'            => 'required|string|max:255',
            'type_id' => 'required|exists:service_provider_types,id',
            // 'phone'           => 'nullable|string|max:50',
            'phone' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('service_providers')
                    ->where(
                        fn($query) =>
                        $query->where(
                            'society_id',
                            $request->user()->hasRole('super_admin')
                                ? $request->society_id
                                : $request->user()->society_id
                        )
                    ),
            ],
            'email'           => 'nullable|email|max:255',
            'cnic'            => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'bio'             => 'nullable|string',
            'profile_image'   => 'nullable|image|max:2048',
        ];

        if ($request->user()->hasRole('super_admin')) {
            $rules['society_id'] = 'required|exists:societies,id';
        }

        $data = $request->validate($rules);

        // Force society for non–super admins
        if (! $request->user()->hasRole('super_admin')) {
            $data['society_id'] = $request->user()->society_id;
        }

        // Normalize checkbox
        $data['is_approved'] = $request->boolean('is_approved', false);

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('service_providers', 'public');
            $data['profile_image'] = $path;  // store relative path only
        }
        $data['created_by'] = $request->user()->id;
        ServiceProvider::create($data);

        return redirect()
            ->route('admin.service-providers.index')
            ->with('success', 'Service Provider added successfully.');
    }


    public function update(Request $request, ServiceProvider $service_provider)
    {
        $rules = [
            'name'            => 'required|string|max:255',
            'type_id' => 'required|exists:service_provider_types,id',

            // 'phone'           => 'nullable|string|max:50',
            'phone' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('service_providers')
                    ->where(
                        fn($query) =>
                        $query->where(
                            'society_id',
                            $request->user()->hasRole('super_admin')
                                ? $request->society_id
                                : $request->user()->society_id
                        )
                    )
                    ->ignore($service_provider->id),
            ],

            'email'           => 'nullable|email|max:255',
            'cnic'            => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'bio'             => 'nullable|string',
            'profile_image'   => 'nullable|image|max:2048',
        ];

        if ($request->user()->hasRole('super_admin')) {
            $rules['society_id'] = 'required|exists:societies,id';
        }

        $data = $request->validate($rules);

        if (! $request->user()->hasRole('super_admin')) {
            $data['society_id'] = $request->user()->society_id;
        }

        $data['is_approved'] = $request->boolean('is_approved', false);

        // Handle new profile image
        if ($request->hasFile('profile_image')) {
            if ($service_provider->profile_image) {
                // Delete old file
                Storage::disk('public')->delete($service_provider->profile_image);
            }

            $path = $request->file('profile_image')->store('service_providers', 'public');
            $data['profile_image'] = $path;
        }

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
    // public function toggle(Request $request, ServiceProvider $service_provider)
    // {
    //     // validate the incoming value:
    //     $data = $request->validate([
    //         'is_active' => 'required|boolean',
    //     ]);

    //     $service_provider->update($data);

    //     return back()->with('success', 'Status updated.');
    // }
    public function toggle(Request $request, ServiceProvider $service_provider)
    {
        $data = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $service_provider->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'id' => $service_provider->id,
                'is_active' => (bool)$service_provider->is_active,
            ]);
        }

        return back()->with('success', 'Status updated.');
    }

    public function approve(Request $request, ServiceProvider $service_provider)
    {
        $data = $request->validate([
            'is_approved' => 'required|boolean',
        ]);


        $service_provider->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'id' => $service_provider->id,
                'is_approved' => (bool)$service_provider->is_approved,
            ]);
        }

        return back()->with('success', 'Approval status updated.');
    }
}
