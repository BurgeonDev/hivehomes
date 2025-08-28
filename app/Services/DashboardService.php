<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get growth data for given range.
     *
     * @param string $range  One of: 'today','yesterday','7d','30d','current_month','last_month','12m'
     * @param int|null $societyId
     * @return array ['categories'=>[], 'series'=>[ ['name'=>'Users','data'=>[]], ... ]]
     */
    public static function growthDataRange(string $range = '12m', ?int $societyId = null): array
    {
        $now = Carbon::now();
        $categories = [];
        $groupByExpr = null;      // SQL expression used as key (Y-m-d or %b/%Y or H:00)
        $displayMap = [];         // map key => display label

        switch ($range) {
            case 'today':
            case 'yesterday':
                // hourly (24 points)
                $base = $range === 'today' ? $now->copy() : $now->copy()->subDay();
                // categories keys will be 'HH'
                for ($h = 0; $h < 24; $h++) {
                    $key = $base->copy()->startOfDay()->addHours($h)->format('H:00');
                    $categories[] = $key;
                }
                $groupByExpr = "DATE_FORMAT(created_at, '%H:00')";
                break;

            case '7d':
                $start = $now->startOfDay()->subDays(6);
                for ($i = 0; $i < 7; $i++) {
                    $d = $start->copy()->addDays($i);
                    $k = $d->format('Y-m-d');
                    $categories[] = $d->format('d M'); // display label e.g., 22 Aug
                    $displayMap[$k] = $d->format('d M'); // map DB key to display
                }
                $groupByExpr = "DATE(created_at)";
                break;

            case '30d':
                $start = $now->startOfDay()->subDays(29);
                for ($i = 0; $i < 30; $i++) {
                    $d = $start->copy()->addDays($i);
                    $k = $d->format('Y-m-d');
                    $categories[] = $d->format('d M');
                    $displayMap[$k] = $d->format('d M');
                }
                $groupByExpr = "DATE(created_at)";
                break;

            case 'current_month':
            case 'last_month':
                $base = $range === 'current_month' ? $now->copy() : $now->copy()->subMonth();
                $daysInMonth = $base->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $d = $base->copy()->startOfMonth()->addDays($i - 1);
                    $k = $d->format('Y-m-d');
                    $categories[] = $d->format('d M');
                    $displayMap[$k] = $d->format('d M');
                }
                $groupByExpr = "DATE(created_at)";
                break;

            case '12m':
            default:
                // last 12 months
                $start = $now->copy()->startOfMonth()->subMonths(11);
                for ($i = 0; $i < 12; $i++) {
                    $d = $start->copy()->addMonths($i);
                    $k = $d->format('Y-m'); // key: 2025-08
                    $categories[] = $d->format('M Y'); // display
                    $displayMap[$k] = $d->format('M Y');
                }
                $groupByExpr = "DATE_FORMAT(created_at, '%Y-%m')";
                break;
        }

        // helper to run query and map results by DB key
        $queryMapper = function ($table, $column = 'created_at') use ($groupByExpr, $now, $range, $societyId) {
            $q = DB::table($table)
                ->selectRaw("$groupByExpr as label, COUNT(*) as cnt")
                ->whereNotNull($column);

            // time filter
            switch ($range) {
                case 'today':
                    $q->whereDate($column, $now->toDateString());
                    break;
                case 'yesterday':
                    $q->whereDate($column, $now->copy()->subDay()->toDateString());
                    break;
                case '7d':
                    $q->whereDate($column, '>=', $now->copy()->subDays(6)->startOfDay()->toDateString());
                    break;
                case '30d':
                    $q->whereDate($column, '>=', $now->copy()->subDays(29)->startOfDay()->toDateString());
                    break;
                case 'current_month':
                    $q->whereMonth($column, $now->month)->whereYear($column, $now->year);
                    break;
                case 'last_month':
                    $lm = $now->copy()->subMonth();
                    $q->whereMonth($column, $lm->month)->whereYear($column, $lm->year);
                    break;
                case '12m':
                default:
                    $q->whereDate($column, '>=', $now->copy()->startOfMonth()->subMonths(11)->toDateString());
                    break;
            }

            if ($societyId) {
                // Only some tables have society_id; products/posts do, users may
                if (Schema::hasColumn($table, 'society_id')) {
                    $q->where('society_id', $societyId);
                } else {
                    $q->where('society_id', $societyId); // if not present this will silently fail; ok to leave
                }
            }

            return $q->groupBy('label')->pluck('cnt', 'label')->toArray();
        };

        // grab row maps
        $usersRows = $queryMapper('users', 'created_at');
        $productsRows = $queryMapper('products', 'created_at');
        $postsRows = $queryMapper('posts', 'created_at');

        // build arrays aligned to categories
        $usersData = [];
        $productsData = [];
        $postsData = [];

        if ($groupByExpr === "DATE_FORMAT(created_at, '%Y-%m')") {
            // month keys format 'YYYY-MM'
            foreach ($displayMap as $key => $label) {
                $k = $key; // key already correct like '2025-08'
                $usersData[] = isset($usersRows[$k]) ? (int)$usersRows[$k] : 0;
                $productsData[] = isset($productsRows[$k]) ? (int)$productsRows[$k] : 0;
                $postsData[] = isset($postsRows[$k]) ? (int)$postsRows[$k] : 0;
            }
        } else {
            // day/hour keys may be 'YYYY-MM-DD' or 'HH:00'
            if ($range === 'today' || $range === 'yesterday') {
                // hourly label keys like '08:00'
                foreach ($categories as $label) {
                    $k = $label; // label equals key 'HH:00'
                    $usersData[] = isset($usersRows[$k]) ? (int)$usersRows[$k] : 0;
                    $productsData[] = isset($productsRows[$k]) ? (int)$productsRows[$k] : 0;
                    $postsData[] = isset($postsRows[$k]) ? (int)$postsRows[$k] : 0;
                }
            } else {
                // categories have displayMap keyed by 'YYYY-MM-DD'
                foreach ($displayMap as $dbKey => $label) {
                    $k = $dbKey;
                    $usersData[] = isset($usersRows[$k]) ? (int)$usersRows[$k] : 0;
                    $productsData[] = isset($productsRows[$k]) ? (int)$productsRows[$k] : 0;
                    $postsData[] = isset($postsRows[$k]) ? (int)$postsRows[$k] : 0;
                }
            }
        }

        return [
            'categories' => array_values($categories),
            'series' => [
                ['name' => 'Users', 'data' => $usersData],
                ['name' => 'Products', 'data' => $productsData],
                ['name' => 'Posts', 'data' => $postsData],
            ],
        ];
    }
}
