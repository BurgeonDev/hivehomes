<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ServiceProviderType;
use App\Models\Society;
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
            'roles',
            'society',
            'posts.comments.user',
            'posts.likedByUsers',
            'products',
            'comments',
            'serviceProviders', // make sure relation exists in User model
        ]);

        // -------------------------
        // Friendly role name
        // -------------------------
        $roleName = null;
        try {
            if (method_exists($user, 'getRoleNames')) {
                $roleName = $user->getRoleNames()->first();
            }
        } catch (\Throwable $e) {
            // ignore
        }

        if (!$roleName && $user->relationLoaded('roles')) {
            $roleName = $user->roles->pluck('name')->first();
        }

        if (!$roleName) {
            try {
                $roleName = $user->roles()->pluck('name')->first();
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $user->role = $roleName ?? 'Member';
        $user->status = isset($user->is_active) ? ucfirst($user->is_active) : 'Unknown';

        // -------------------------
        // Basic counts (only user-specific)
        // -------------------------
        $counts = [
            'posts'     => $user->posts()->count(),
            'products'  => $user->products()->count(),
            'comments'  => $user->comments()->count(),
        ];

        // Likes received on user's posts
        $likesReceived = (int) DB::table('post_user_likes')
            ->join('posts', 'post_user_likes.post_id', '=', 'posts.id')
            ->where('posts.user_id', $user->id)
            ->count();

        $counts['likes_received'] = $likesReceived;

        // -------------------------
        // Posts by status
        // -------------------------
        $postStatuses = [
            'pending'  => $user->posts()->where('status', 'pending')->count(),
            'approved' => $user->posts()->where('status', 'approved')->count(),
            'rejected' => $user->posts()->where('status', 'rejected')->count(),
            'expired'  => $user->posts()->where('status', 'expired')->count(),
        ];

        // -------------------------
        // Products by status
        // -------------------------
        $productStatuses = [
            'pending'  => $user->products()->where('status', 'pending')->count(),
            'approved' => $user->products()->where('status', 'approved')->count(),
            'rejected' => $user->products()->where('status', 'rejected')->count(),
        ];

        // -------------------------
        // Paginated lists
        // -------------------------
        $products = $user->products()->latest()->paginate(9)->withQueryString();
        $posts = $user->posts()->latest()->paginate(9)->withQueryString();

        // -------------------------
        // Service Reviews (for services created by this user)
        // -------------------------
        $serviceReviews = null;
        try {
            if (class_exists(\App\Models\ServiceProviderReview::class)) {
                $serviceReviews = \App\Models\ServiceProviderReview::whereIn(
                    'service_provider_id',
                    $user->serviceProviders->pluck('id')
                )
                    ->with(['provider', 'user'])
                    ->latest()
                    ->paginate(8)
                    ->withQueryString();
            } else {
                $query = DB::table('service_provider_reviews')
                    ->join('service_providers', 'service_provider_reviews.service_provider_id', '=', 'service_providers.id')
                    ->where('service_providers.user_id', $user->id)
                    ->select('service_provider_reviews.*');

                $serviceReviews = $query->paginate(8);
            }
        } catch (\Throwable $e) {
            $serviceReviews = new LengthAwarePaginator([], 0, 8, 1, [
                'path' => url()->current()
            ]);
        }
        $categories = ProductCategory::all();
        $societies = Society::all();
        $providers = $user->serviceProviders ?? collect();
        $serviceTypes = ServiceProviderType::all();


        return view('frontend.dashboard.index', compact(
            'user',
            'counts',
            'postStatuses',
            'productStatuses',
            'products',
            'posts',
            'serviceReviews',
            'categories',
            'societies',
            'providers',
            'serviceTypes'
        ));
    }
}
