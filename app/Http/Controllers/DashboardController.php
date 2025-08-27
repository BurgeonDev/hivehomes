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

        $usersCount = User::when(!$isSuper, $queryScope)->count();
        $societiesCount = Society::count();
        $totalProducts = Product::when(!$isSuper, $queryScope)->count();
        $totalServiceProviders = ServiceProvider::when(!$isSuper, $queryScope)->count();
        $approvedProviders = ServiceProvider::where('is_approved', true)->when(!$isSuper, $queryScope)->count();
        $pendingProviders = ServiceProvider::where('is_approved', false)->when(!$isSuper, $queryScope)->count();
        $avgApprovalTime = ServiceProvider::where('is_approved', true)
            ->when(!$isSuper, $queryScope)
            ->select(DB::raw('AVG(DATEDIFF(updated_at, created_at)) as avg_days'))
            ->value('avg_days') ?? 0;

        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();
        $daysInMonth = Carbon::now()->daysInMonth;
        $prevMonthStart = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $prevMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();

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
            : 0;
        $pendingChange = ($prevPostsByStatus['pending'] ?? 0) > 0
            ? round((($postsByStatus['pending'] ?? 0) - ($prevPostsByStatus['pending'] ?? 0)) / ($prevPostsByStatus['pending'] ?? 1) * 100, 1)
            : 0;
        $rejectedChange = ($prevPostsByStatus['rejected'] ?? 0) > 0
            ? round((($postsByStatus['rejected'] ?? 0) - ($prevPostsByStatus['rejected'] ?? 0)) / ($prevPostsByStatus['rejected'] ?? 1) * 100, 1)
            : 0;

        $productsByCondition = Product::select('condition', DB::raw('count(*) as total'))
            ->when(!$isSuper, $queryScope)
            ->groupBy('condition')
            ->pluck('total', 'condition');

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
        $weeklyChange = $prevWeeklyPosts > 0 ? round(($totalWeeklyPosts - $prevWeeklyPosts) / $prevWeeklyPosts * 100, 1) : 0;
        $weeklyChangeClass = $weeklyChange >= 0 ? 'success' : 'danger';
        $weeklyChangeIcon = $weeklyChange >= 0 ? 'up' : 'down';

        $totalPosts = Post::when(!$isSuper, $queryScope)->count();
        $approvedPosts = Post::where('status', 'approved')->when(!$isSuper, $queryScope)->count();
        $completionRate = $totalPosts > 0 ? round($approvedPosts / $totalPosts * 100) : 0;
        $approvalRate = $completionRate;

        $newPostsThisMonth = Post::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->count();

        $pendingPosts = Post::where('status', 'pending')->when(!$isSuper, $queryScope)->count();

        $avgResponseTime = Post::where('status', 'approved')
            ->when(!$isSuper, $queryScope)
            ->select(DB::raw('AVG(DATEDIFF(updated_at, created_at)) as avg_days'))
            ->value('avg_days') ?? 0;

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

        $totalUsers = $usersCount;
        $prevMonthUsers = User::whereBetween('created_at', [$prevMonthStart . ' 00:00:00', $prevMonthEnd . ' 23:59:59'])->when(!$isSuper, $queryScope)->count();
        $usersChange = $prevMonthUsers > 0 ? round(($totalUsers - $prevMonthUsers) / $prevMonthUsers * 100, 1) : 0;
        $usersChangeClass = $usersChange >= 0 ? 'success' : 'danger';

        $newPosts = $newPostsThisMonth;
        $newProducts = Product::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->when(!$isSuper, $queryScope)->count();
        $postsPercentage = $totalThisMonth > 0 ? round($newPosts / $totalThisMonth * 100, 1) : 0;
        $productsPercentage = $totalThisMonth > 0 ? round($newProducts / $totalThisMonth * 100, 1) : 0;

        $totalPostsMonthly = $totalThisMonth;
        $approvedMonthly = $postsByStatus['approved'] ?? 0;
        $pendingMonthly = $postsByStatus['pending'] ?? 0;
        $rejectedMonthly = $postsByStatus['rejected'] ?? 0;

        $newUsersThisMonth = User::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->when(!$isSuper, $queryScope)
            ->count();

        $productsNew = $productsByCondition['new'] ?? 0;
        $productsUsed = $productsByCondition['used'] ?? 0;

        return view('admin.dashboard', compact(
            'usersCount',
            'societiesCount',
            'postsByStatus',
            'productsByCondition',
            'series',
            'labels',
            'totalThisMonth',
            'avgPerDay',
            'weeklyPosts',
            'weeklyLabels',
            'totalWeeklyPosts',
            'weeklyChange',
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
            'avgApprovalTime',
            'approvalRate'
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
