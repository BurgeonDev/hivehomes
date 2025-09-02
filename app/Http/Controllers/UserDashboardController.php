<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // eager load related data used in the view
        $user->load([
            'society',
            'posts.comments.user',
            // if your Post model has a many-to-many likes relation name different than 'likedByUsers'
            // adjust the relation name accordingly
            'posts.likedByUsers',
            'products',
            'comments', // if user has comments()
        ]);

        // expose a friendly status attribute for the view (view expects $user->status)
        $user->status = isset($user->is_active) ? ucfirst($user->is_active) : 'Unknown';

        // Basic counts
        $counts = [
            'posts'     => $user->posts()->count(),
            'products'  => $user->products()->count(),
            'comments'  => $user->comments()->count(),
        ];

        // Likes received on user's posts (counts entries in post_user_likes for posts belonging to this user)
        $likesReceived = (int) DB::table('post_user_likes')
            ->join('posts', 'post_user_likes.post_id', '=', 'posts.id')
            ->where('posts.user_id', $user->id)
            ->count();

        $counts['likes_received'] = $likesReceived;

        // Posts by status (pending / approved / rejected / expired)
        $postStatuses = [
            'pending'  => $user->posts()->where('status', 'pending')->count(),
            'approved' => $user->posts()->where('status', 'approved')->count(),
            'rejected' => $user->posts()->where('status', 'rejected')->count(),
            'expired'  => $user->posts()->where('status', 'expired')->count(),
        ];

        // Products by status (pending / approved / rejected)
        $productStatuses = [
            'pending'  => $user->products()->where('status', 'pending')->count(),
            'approved' => $user->products()->where('status', 'approved')->count(),
            'rejected' => $user->products()->where('status', 'rejected')->count(),
        ];

        // Paginated lists for the tabs
        $products = $user->products()->latest()->paginate(9)->withQueryString();
        $posts = $user->posts()->latest()->paginate(9)->withQueryString();

        // Service reviews: attempt multiple strategies with safe fallback.
        // Schema shows `service_provider_reviews` table. We try:
        // 1) Eloquent model App\Models\ServiceProviderReview with relationship to serviceProvider
        // 2) Raw join between service_provider_reviews and service_providers where service_providers.user_id = current user
        // If neither is available, provide an empty LengthAwarePaginator so the view can call ->count() and ->links().
        $serviceReviews = null;
        try {
            if (class_exists(\App\Models\ServiceProviderReview::class)) {
                // assumes ServiceProviderReview has relationship 'serviceProvider' pointing to service_providers table
                $serviceReviews = \App\Models\ServiceProviderReview::whereHas('serviceProvider', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->latest()->paginate(8)->withQueryString();
            } else {
                // fallback to query builder join (if service_providers table exists)
                $query = DB::table('service_provider_reviews')
                    ->join('service_providers', 'service_provider_reviews.service_provider_id', '=', 'service_providers.id')
                    ->where('service_providers.user_id', $user->id)
                    ->select('service_provider_reviews.*');

                // query builder supports paginate()
                $serviceReviews = $query->paginate(8);
            }
        } catch (\Throwable $e) {
            // safe fallback: empty paginator (so view->count() and ->links() work)
            $serviceReviews = new LengthAwarePaginator([], 0, 8, 1, [
                'path' => url()->current()
            ]);
        }

        return view('frontend.dashboard.index', compact(
            'user',
            'counts',
            'postStatuses',
            'productStatuses',
            'products',
            'posts',
            'serviceReviews'
        ));
    }
}
