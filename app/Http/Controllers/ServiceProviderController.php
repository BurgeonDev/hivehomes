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
        $query = ServiceProvider::where('is_approved', true)
            ->with('society', 'type')
            ->withCount('reviews')
            ->withAvg('reviews as average_rating', 'rating');
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
        if ($request->filled('rating')) {
            $rating = (int) $request->input('rating');
            $query->whereHas('reviews', function ($qb) use ($rating) {
                $qb->select('service_provider_id', DB::raw('AVG(rating) as avg_rating'))
                    ->groupBy('service_provider_id')
                    ->havingRaw('AVG(rating) >= ?', [$rating]);
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
            ->when(
                ! $user->hasRole('super_admin'),
                fn($qb) => $qb->where('society_id', $user->society_id)
            )
            ->count();

        $types = ServiceProviderType::withCount(['providers as approved_count' => function ($qb) use ($user) {
            $qb->where('is_approved', true);
            if (! $user->hasRole('super_admin')) {
                $qb->where('society_id', $user->society_id);
            }
        }])->orderBy('name')->get();
        if ($request->ajax()) {
            return view('frontend.service_providers.partials.providers-list', compact('providers'))->render();
        }
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
