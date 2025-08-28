<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use App\Models\Society;
use App\Models\User;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isSuper = $user->hasRole('super_admin');
        $societyId = $user->society_id;

        $queryScope = $isSuper
            ? fn($q) => $q
            : fn($q) => $q->where('society_id', $societyId);

        // Basic counts
        $usersCount = User::when(!$isSuper, $queryScope)->count();
        $societiesCount = Society::count();
        $totalProducts = Product::when(!$isSuper, $queryScope)->count();

        // Dates
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();
        $daysInMonth = Carbon::now()->daysInMonth;
        $prevMonthStart = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $prevMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Posts by status (this month & previous month)
        $postsByStatus = Post::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->groupBy('status')
            ->pluck('total', 'status');

        $prevPostsByStatus = Post::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$prevMonthStart . ' 00:00:00', $prevMonthEnd . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->groupBy('status')
            ->pluck('total', 'status');

        $approvedChange = ($prevPostsByStatus['approved'] ?? 0) > 0
            ? round((($postsByStatus['approved'] ?? 0) - ($prevPostsByStatus['approved'] ?? 0)) / ($prevPostsByStatus['approved'] ?? 1) * 100, 1)
            : (($postsByStatus['approved'] ?? 0) > 0 ? 100 : 0);

        $pendingChange = ($prevPostsByStatus['pending'] ?? 0) > 0
            ? round((($postsByStatus['pending'] ?? 0) - ($prevPostsByStatus['pending'] ?? 0)) / ($prevPostsByStatus['pending'] ?? 1) * 100, 1)
            : (($postsByStatus['pending'] ?? 0) > 0 ? 100 : 0);

        $rejectedChange = ($prevPostsByStatus['rejected'] ?? 0) > 0
            ? round((($postsByStatus['rejected'] ?? 0) - ($prevPostsByStatus['rejected'] ?? 0)) / ($prevPostsByStatus['rejected'] ?? 1) * 100, 1)
            : (($postsByStatus['rejected'] ?? 0) > 0 ? 100 : 0);

        // Products by condition (this scope)
        $productsByCondition = Product::select('condition', DB::raw('count(*) as total'))
            ->when(!$isSuper, $queryScope)
            ->groupBy('condition')
            ->pluck('total', 'condition');

        // Previous month products by condition (for % change)
        $prevProductsByCondition = Product::select('condition', DB::raw('count(*) as total'))
            ->when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$prevMonthStart . ' 00:00:00', $prevMonthEnd . ' 23:59:59'])
            ->groupBy('condition')
            ->pluck('total', 'condition');

        // Build products condition change map
        $productsConditionChange = [];
        foreach ($productsByCondition as $cond => $count) {
            $prev = $prevProductsByCondition[$cond] ?? 0;
            $productsConditionChange[$cond] = $prev > 0
                ? round((($count - $prev) / $prev) * 100, 1)
                : ($count > 0 ? 100 : 0);
        }

        // Daily posts series for current month
        $dailyQuery = DB::table('posts')
            ->when(!$isSuper, fn($q) => $q->where('posts.society_id', $societyId))
            ->whereBetween('posts.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(DB::raw('DATE(posts.created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date');

        $dailyTotals = $dailyQuery->get()->keyBy('date')->map(fn($r) => (int) $r->total);

        $series = [];
        $labels = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::now()->startOfMonth()->addDays($d - 1)->toDateString();
            $labels[] = $date;
            $series[] = $dailyTotals->has($date) ? (int) $dailyTotals->get($date) : 0;
        }

        $totalThisMonth = array_sum($series);
        $avgPerDay = $daysInMonth > 0 ? round($totalThisMonth / $daysInMonth, 2) : 0;

        // Weekly posts (this week & previous week)
        $weekStart = Carbon::now()->startOfWeek()->toDateString();
        $weekEnd = Carbon::now()->endOfWeek()->toDateString();

        $weeklyPosts = [];
        $weeklyLabels = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
        for ($i = 0; $i < 7; $i++) {
            $day = Carbon::now()->startOfWeek()->addDays($i)->toDateString();
            $count = Post::whereDate('created_at', $day)->when(!$isSuper, $queryScope)->count();
            $weeklyPosts[] = $count;
        }
        $totalWeeklyPosts = array_sum($weeklyPosts);

        $prevWeekStart = Carbon::now()->subWeek()->startOfWeek()->toDateString();
        $prevWeekEnd = Carbon::now()->subWeek()->endOfWeek()->toDateString();

        $prevWeeklyPosts = Post::whereBetween('created_at', [$prevWeekStart . ' 00:00:00', $prevWeekEnd . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->count();

        // weekly absolute and percent change for posts
        $weeklyChangeAbsolute = $totalWeeklyPosts - $prevWeeklyPosts;
        $weeklyChangePercent = $prevWeeklyPosts > 0
            ? round((($totalWeeklyPosts - $prevWeeklyPosts) / $prevWeeklyPosts) * 100, 1)
            : ($totalWeeklyPosts > 0 ? 100 : 0);

        // keep backward compatibility with existing $weeklyChange usage (was percent)
        $weeklyChange = $weeklyChangePercent;
        $weeklyChangeClass = $weeklyChange >= 0 ? 'success' : 'danger';
        $weeklyChangeIcon = $weeklyChange >= 0 ? 'up' : 'down';

        // Total posts, approval & completion
        $totalPosts = Post::when(!$isSuper, $queryScope)->count();
        $approvedPosts = Post::where('status', 'approved')->when(!$isSuper, $queryScope)->count();
        $completionRate = $totalPosts > 0 ? round($approvedPosts / $totalPosts * 100) : 0;

        $newPostsThisMonth = Post::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->count();

        $pendingPosts = Post::where('status', 'pending')->when(!$isSuper, $queryScope)->count();

        $avgResponseTime = Post::where('status', 'approved')
            ->when(!$isSuper, $queryScope)
            ->select(DB::raw('AVG(DATEDIFF(updated_at, created_at)) as avg_days'))
            ->value('avg_days') ?? 0;

        // Monthly series (last 8 months)
        $monthlyPosts = [];
        $monthlyProducts = [];
        $monthlyLabels = [];
        for ($m = 7; $m >= 0; $m--) {
            $month = Carbon::now()->subMonths($m);
            $monthStart = $month->startOfMonth()->toDateString();
            $monthEnd = $month->endOfMonth()->toDateString();
            $postCount = Post::whereBetween('created_at', [$monthStart . ' 00:00:00', $monthEnd . ' 23:59:59'])->when(!$isSuper, $queryScope)->count();
            $productCount = Product::whereBetween('created_at', [$monthStart . ' 00:00:00', $monthEnd . ' 23:59:59'])->when(!$isSuper, $queryScope)->count();
            $monthlyPosts[] = $postCount;
            $monthlyProducts[] = -$productCount;
            $monthlyLabels[] = $month->format('M');
        }

        // Users metrics (monthly)
        $totalUsers = $usersCount;
        $newUsersThisMonth = User::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->count();
        $usersPrevTotal = $usersCount - $newUsersThisMonth;
        $usersChange = $usersPrevTotal > 0 ? round(($newUsersThisMonth / $usersPrevTotal) * 100, 1) : 0;
        $usersChangeClass = $usersChange >= 0 ? 'success' : 'danger';

        // New products this month and percentages
        $newPosts = $newPostsThisMonth;
        $newProducts = Product::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->when(!$isSuper, $queryScope)->count();
        $totalActivitiesThisMonth = $newPosts + $newProducts;
        $postsPercentage = $totalActivitiesThisMonth > 0 ? round($newPosts / $totalActivitiesThisMonth * 100, 1) : 0;
        $productsPercentage = $totalActivitiesThisMonth > 0 ? round($newProducts / $totalActivitiesThisMonth * 100, 1) : 0;

        $totalPostsMonthly = $newPosts;
        $approvedMonthly = $postsByStatus['approved'] ?? 0;
        $pendingMonthly = $postsByStatus['pending'] ?? 0;
        $rejectedMonthly = $postsByStatus['rejected'] ?? 0;
        $approvalRate = $totalPostsMonthly > 0 ? round($approvedMonthly / $totalPostsMonthly * 100) : 0;

        $productsNew = $productsByCondition['new'] ?? 0;
        $productsUsed = $productsByCondition['used'] ?? 0;

        // ===== Service Providers KPIs =====
        $totalServiceProviders = ServiceProvider::when(!$isSuper, $queryScope)->count();

        // Current month approved & pending
        $approvedProviders = ServiceProvider::where('is_approved', 1)
            ->when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        $pendingProviders = ServiceProvider::where('is_approved', 0)
            ->when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        // Previous month approved & pending
        $prevApproved = ServiceProvider::where('is_approved', 1)
            ->when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$prevMonthStart . ' 00:00:00', $prevMonthEnd . ' 23:59:59'])
            ->count();

        $prevPending = ServiceProvider::where('is_approved', 0)
            ->when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$prevMonthStart . ' 00:00:00', $prevMonthEnd . ' 23:59:59'])
            ->count();

        // Percentage changes for providers
        $approvedProvidersChange = $prevApproved > 0
            ? round((($approvedProviders - $prevApproved) / $prevApproved) * 100, 1)
            : ($approvedProviders > 0 ? 100 : 0);

        $pendingProvidersChange = $prevPending > 0
            ? round((($pendingProviders - $prevPending) / $prevPending) * 100, 1)
            : ($pendingProviders > 0 ? 100 : 0);

        // Average approval time (days)
        $avgApprovalTime = ServiceProvider::where('is_approved', 1)
            ->when(!$isSuper, $queryScope)
            ->avg(DB::raw('DATEDIFF(updated_at, created_at)')) ?? 0;
        $avgApprovalTime = round($avgApprovalTime, 1);

        // Products weekly comparison (this week vs previous week) — named to match Blade
        $thisWeekProducts = Product::when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$weekStart . ' 00:00:00', $weekEnd . ' 23:59:59'])
            ->count();

        $prevWeekProducts = Product::when(!$isSuper, $queryScope)
            ->whereBetween('created_at', [$prevWeekStart . ' 00:00:00', $prevWeekEnd . ' 23:59:59'])
            ->count();

        $usersChangeAbsolute = $thisWeekProducts - $prevWeekProducts;
        $usersChangePercent = $prevWeekProducts > 0
            ? round((($thisWeekProducts - $prevWeekProducts) / $prevWeekProducts) * 100, 1)
            : ($thisWeekProducts > 0 ? 100 : 0);

        // Additional Society KPIs for Super Admin
        $topSocietiesMembers = collect();
        $bottomSocietiesMembers = collect();
        $topSocietiesProducts = collect();
        $topSocietiesProviders = collect();
        $membersLabels = [];
        $membersSeries = [];
        $productsLabels = [];
        $productsSeries = [];
        $providersLabels = [];
        $providersSeries = [];
        $avgMembersPerSociety = 0;
        $avgProductsPerSociety = 0;
        $avgProvidersPerSociety = 0;

        if ($isSuper) {
            $topSocietiesMembers = Society::withCount('users')->orderByDesc('users_count')->take(5)->get();
            $bottomSocietiesMembers = Society::withCount('users')->orderBy('users_count')->take(5)->get();
            $topSocietiesProducts = Society::withCount('products')->orderByDesc('products_count')->take(5)->get();
            $topSocietiesProviders = Society::withCount('serviceProviders')->orderByDesc('service_providers_count')->take(5)->get();

            $membersLabels = $topSocietiesMembers->pluck('name')->toArray();
            $membersSeries = $topSocietiesMembers->pluck('users_count')->toArray();
            $productsLabels = $topSocietiesProducts->pluck('name')->toArray();
            $productsSeries = $topSocietiesProducts->pluck('products_count')->toArray();
            $providersLabels = $topSocietiesProviders->pluck('name')->toArray();
            $providersSeries = $topSocietiesProviders->pluck('service_providers_count')->toArray();

            $totalMembers = User::count();
            $avgMembersPerSociety = $societiesCount > 0 ? round($totalMembers / $societiesCount, 2) : 0;
            $avgProductsPerSociety = $societiesCount > 0 ? round($totalProducts / $societiesCount, 2) : 0;
            $avgProvidersPerSociety = $societiesCount > 0 ? round($totalServiceProviders / $societiesCount, 2) : 0;
        }

        return view('admin.dashboard', compact(
            'usersCount',
            'societiesCount',
            'postsByStatus',
            'productsByCondition',
            'productsConditionChange',
            'series',
            'labels',
            'totalThisMonth',
            'avgPerDay',
            'weeklyPosts',
            'weeklyLabels',
            'totalWeeklyPosts',
            'weeklyChange',
            'weeklyChangeAbsolute',
            'weeklyChangePercent',
            'weeklyChangeClass',
            'weeklyChangeIcon',
            'completionRate',
            'totalPosts',
            'newPostsThisMonth',
            'pendingPosts',
            'avgResponseTime',
            'monthlyPosts',
            'monthlyProducts',
            'monthlyLabels',
            'totalUsers',
            'usersChange',
            'usersChangeClass',
            'newPosts',
            'newProducts',
            'postsPercentage',
            'productsPercentage',
            'totalPostsMonthly',
            'approvedMonthly',
            'pendingMonthly',
            'rejectedMonthly',
            'productsNew',
            'productsUsed',
            'newUsersThisMonth',
            'approvedChange',
            'pendingChange',
            'rejectedChange',
            'totalProducts',
            'totalServiceProviders',
            'approvedProviders',
            'pendingProviders',
            'approvedProvidersChange',
            'pendingProvidersChange',
            'avgApprovalTime',
            'approvalRate',
            'isSuper',
            'topSocietiesMembers',
            'bottomSocietiesMembers',
            'topSocietiesProducts',
            'topSocietiesProviders',
            'membersLabels',
            'membersSeries',
            'productsLabels',
            'productsSeries',
            'providersLabels',
            'providersSeries',
            'avgMembersPerSociety',
            'avgProductsPerSociety',
            'avgProvidersPerSociety',
            'usersChangeAbsolute',
            'usersChangePercent'
        ));
    }



    public function projectsJson(Request $request)
    {
        $user = auth()->user();
        $isSuper = $user->hasRole('super_admin');
        $societyId = $user->society_id;

        $posts = Post::when(!$isSuper, fn($q) => $q->where('society_id', $societyId))
            ->with('user')
            ->get()
            ->map(function ($post) {
                $statusNum = match ($post->status) {
                    'approved' => 100,
                    'pending' => 50,
                    'rejected' => 0,
                    default => 0,
                };
                return [
                    'id' => $post->id,
                    'project_name' => $post->title,
                    'date' => $post->created_at->format('Y-m-d'),
                    'project_img' => $post->image ?? 'default.png',
                    'project_leader' => $post->user->name ?? 'N/A',
                    'team' => [],
                    'status' => $statusNum,
                ];
            });

        return response()->json(['data' => $posts]);
    }
}
