<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\ServiceProviderTypeController;
use App\Models\ServiceProviderType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\Society;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServiceProviderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = ServiceProvider::where('is_approved', true)
            ->with('society', 'type', 'creator')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating'); // adds reviews_avg_rating

        if (! $user->hasRole('super_admin')) {
            $query->where('society_id', $user->society_id);
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(
                fn($qb) =>
                $qb->where('name', 'like', "%{$q}%")
                    ->orWhere('bio', 'like', "%{$q}%")
            );
        }

        // safe rating filter using actual reviews table
        if ($request->filled('rating')) {
            $rating = (int) $request->input('rating');
            $rating = max(1, min(5, $rating));

            $query->whereExists(function ($sub) use ($rating) {
                $sub->select(DB::raw(1))
                    ->from('service_provider_reviews')
                    ->whereColumn('service_provider_reviews.service_provider_id', 'service_providers.id')
                    ->groupBy('service_provider_reviews.service_provider_id')
                    ->havingRaw('AVG(service_provider_reviews.rating) >= ?', [$rating]);
            });
        }

        if ($request->filled('type')) {
            $query->where('type_id', $request->input('type'));
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'most_reviewed' => $query->orderByDesc('reviews_count'),
            default => $query->orderByDesc('created_at'),
        };

        $providers = $query->paginate(8)->withQueryString();

        $totalProviders = ServiceProvider::where('is_approved', true)
            ->when(! $user->hasRole('super_admin'), fn($qb) => $qb->where('society_id', $user->society_id))
            ->count();

        $types = ServiceProviderType::withCount(['providers as approved_count' => function ($qb) use ($user) {
            $qb->where('is_approved', true);
            if (! $user->hasRole('super_admin')) {
                $qb->where('society_id', $user->society_id);
            }
        }])->orderBy('name')->get();

        // -------------------------
        // ratingStats (robust approach)
        // -------------------------
        // initialize
        $ratingStats = [
            5 => ['count' => 0, 'percent' => 0],
            4 => ['count' => 0, 'percent' => 0],
            3 => ['count' => 0, 'percent' => 0],
            2 => ['count' => 0, 'percent' => 0],
            1 => ['count' => 0, 'percent' => 0],
        ];

        // get provider ids in the current scope (approved + society filter)
        $providerIdsQuery = ServiceProvider::where('is_approved', true);
        if (! $user->hasRole('super_admin')) {
            $providerIdsQuery->where('society_id', $user->society_id);
        }
        $providerIds = $providerIdsQuery->pluck('id')->toArray();

        if (! empty($providerIds)) {
            // compute average rating per provider
            $avgRows = DB::table('service_provider_reviews')
                ->select('service_provider_id', DB::raw('AVG(rating) as avg_rating'))
                ->whereIn('service_provider_id', $providerIds)
                ->groupBy('service_provider_id')
                ->get();

            // tally rounded star per provider (1..5)
            $counts = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0
            ];
            foreach ($avgRows as $r) {
                $star = (int) round($r->avg_rating);
                $star = max(1, min(5, $star));
                $counts[$star] = ($counts[$star] ?? 0) + 1;
            }

            $totalProvidersWithReviews = array_sum($counts);
            if ($totalProvidersWithReviews > 0) {
                foreach ($counts as $star => $cnt) {
                    $ratingStats[$star]['count'] = (int) $cnt;
                    $ratingStats[$star]['percent'] = (int) round(($cnt / $totalProvidersWithReviews) * 100);
                }
            }
        }
        $serviceTypes = ServiceProviderType::orderBy('name')->get();
        $societies =  Society::all();

        if ($request->ajax()) {
            return view('frontend.service_providers.partials.providers-list', compact('providers'))->render();
        }

        return view('frontend.service_providers.index', compact('providers', 'totalProviders', 'types', 'ratingStats', 'serviceTypes', 'societies'));
    }

    public function show(ServiceProvider $service_provider)
    {

        $reviews = $service_provider->reviews()->with('user')->latest()->get();
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 2) : 0;

        // rating counts and distribution
        $ratingCounts = $reviews->groupBy('rating')->map->count()->toArray();
        $ratingDistribution = [];
        foreach ([1, 2, 3, 4, 5] as $star) {
            $ratingDistribution[$star] = $totalReviews > 0
                ? round(($ratingCounts[$star] ?? 0) / $totalReviews * 100)
                : 0;
        }

        $reviewsThisWeek = $reviews->where('created_at', '>=', now()->subWeek())->count();

        return view('frontend.service_providers.show', [
            'provider'            => $service_provider,
            'reviews'             => $reviews,
            'totalReviews'        => $totalReviews,
            'averageRating'       => $averageRating,
            'ratingCounts'        => $ratingCounts,
            'ratingDistribution'  => $ratingDistribution,
            'reviewsThisWeek'     => $reviewsThisWeek,
        ]);
    }
    public function storeReview(Request $request, ServiceProvider $service_provider)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Use $service_provider instead of $provider
        $service_provider->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
    public function store(Request $request)
    {
        // 1. Base validation
        $rules = [
            'name'            => 'required|string|max:255',
            'type_id' => 'required|exists:service_provider_types,id',
            'phone'           => 'nullable|string|max:50',
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
            ->route('service-providers.index')
            ->with('success', 'Service Provider added successfully.');
    }
}
