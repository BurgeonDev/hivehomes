<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get growth data for users, products and posts for last $months months.
     *
     * @param int $months
     * @param int|null $societyId  // pass society id for society-admin, null for super-admin (global)
     * @return array ['categories' => [...], 'series' => [ ['name'=>'Users','data'=>[...] ], ... ]]
     */
    public static function growthData(int $months = 12, ?int $societyId = null): array
    {
        $months = max(1, $months);
        $start = Carbon::now()->startOfMonth()->subMonths($months - 1);

        // prepare category labels (e.g. "Aug/2025" or "Aug/25" you can change format)
        $categories = [];
        for ($i = 0; $i < $months; $i++) {
            $categories[] = $start->copy()->addMonths($i)->format('M/Y');
        }

        // initialize arrays with zeros
        $usersData = array_fill(0, $months, 0);
        $productsData = array_fill(0, $months, 0);
        $postsData = array_fill(0, $months, 0);

        // helper to map query results into the zero-filled arrays
        $mapResults = function ($rows) use ($categories, $months) {
            $out = array_fill(0, $months, 0);
            // $rows is associative ['label' => count]
            foreach ($rows as $label => $count) {
                $index = array_search($label, $categories, true);
                if ($index !== false) {
                    $out[$index] = (int) $count;
                }
            }
            return $out;
        };

        // Users
        $usersQuery = DB::table('users')
            ->selectRaw("DATE_FORMAT(created_at, '%b/%Y') as label, COUNT(*) as cnt")
            ->whereNotNull('created_at')
            ->where('created_at', '>=', $start->toDateString())
            ->groupBy('label');

        if ($societyId) {
            $usersQuery->where('society_id', $societyId);
        }

        $usersRows = $usersQuery->pluck('cnt', 'label')->toArray();
        $usersData = $mapResults($usersRows);

        // Products
        $productsQuery = DB::table('products')
            ->selectRaw("DATE_FORMAT(created_at, '%b/%Y') as label, COUNT(*) as cnt")
            ->whereNotNull('created_at')
            ->where('created_at', '>=', $start->toDateString())
            ->groupBy('label');

        if ($societyId) {
            $productsQuery->where('society_id', $societyId);
        }

        $productsRows = $productsQuery->pluck('cnt', 'label')->toArray();
        $productsData = $mapResults($productsRows);

        // Posts
        $postsQuery = DB::table('posts')
            ->selectRaw("DATE_FORMAT(created_at, '%b/%Y') as label, COUNT(*) as cnt")
            ->whereNotNull('created_at')
            ->where('created_at', '>=', $start->toDateString())
            ->groupBy('label');

        if ($societyId) {
            $postsQuery->where('society_id', $societyId);
        }

        $postsRows = $postsQuery->pluck('cnt', 'label')->toArray();
        $postsData = $mapResults($postsRows);

        return [
            'categories' => $categories,
            'series' => [
                ['name' => 'Users', 'data' => $usersData],
                ['name' => 'Products', 'data' => $productsData],
                ['name' => 'Posts', 'data' => $postsData],
            ],
        ];
    }
}
