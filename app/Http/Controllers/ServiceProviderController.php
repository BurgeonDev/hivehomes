<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\ServiceProviderTypeController;
use App\Models\ServiceProviderType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use Carbon\Carbon;

class ServiceProviderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Base query: only approved providers
        $query = ServiceProvider::where('is_approved', true)
            ->with('society', 'type')
            ->withCount('reviews')
            ->withAvg('reviews as average_rating', 'rating');

        // If not super-admin, scope to their society
        if (! $user->hasRole('super_admin')) {
            $query->where('society_id', $user->society_id);
        }

        // Search by name or bio
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(
                fn($q2) =>
                $q2->where('name', 'like', "%{$q}%")
                    ->orWhere('bio',  'like', "%{$q}%")
            );
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type_id', $request->input('type'));
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest'        => $query->orderBy('created_at', 'asc'),
            'most_reviewed' => $query->orderByDesc('reviews_count'),
            default         => $query->orderByDesc('created_at'),
        };

        $providers = $query->paginate(8)->withQueryString();

        // KPI: total approved providers
        $totalProviders = ServiceProvider::where('is_approved', true)
            ->when(
                ! $user->hasRole('super_admin'),
                fn($q) =>
                $q->where('society_id', $user->society_id)
            )->count();

        // AJAX support
        if ($request->ajax()) {
            return view('frontend.service_providers.partials.providers-list', compact('providers'))->render();
        }
        $types = ServiceProviderType::orderBy('name')->get();
        return view('frontend.service_providers.index', compact('providers', 'totalProviders', 'types'));
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
}
