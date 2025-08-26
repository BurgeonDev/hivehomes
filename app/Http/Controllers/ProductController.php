<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of approved products for the member's society,
     * with live filtering, searching and sorting. Super admin sees all.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Base query: only approved products (super admin bypasses society filter)
        $query = Product::with(['primaryImage', 'seller', 'society', 'category'])
            ->where('status', 'approved');

        // Allow super admin to see all products. Adjust this to your role implementation if needed.
        $isSuperAdmin = (isset($user->role) && $user->role === 'super_admin')
            || (method_exists($user, 'hasRole') && $user->hasRole('super_admin'));

        if (! $isSuperAdmin) {
            $query->where('society_id', $user->society_id);
        }

        // --------------------------
        // SEARCH (title OR description)
        // --------------------------
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }

        // --------------------------
        // FILTERS
        // --------------------------
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // condition (enum: new, like_new, used, refurbished, other, etc.)
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // negotiable (checkbox => '1')
        if ($request->filled('is_negotiable') && $request->is_negotiable == '1') {
            $query->where('is_negotiable', 1);
        }

        // featured only (and not expired)
        if ($request->filled('is_featured') && $request->is_featured == '1') {
            $query->where('is_featured', 1)
                ->where(function ($q) {
                    $q->whereNull('featured_until')
                        ->orWhere('featured_until', '>=', now());
                });
        }

        // --------------------------
        // SORTING
        // --------------------------
        switch ($request->get('sort', 'latest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'alpha':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
        }

        // --------------------------
        // PAGINATION (per_page with bounds)
        // --------------------------
        $perPage = (int) $request->get('per_page', 12);
        // enforce sane bounds
        $perPage = $perPage <= 0 ? 12 : $perPage;
        $perPage = $perPage > 48 ? 48 : $perPage; // max 48 to avoid heavy queries

        $products = $query
            ->paginate($perPage)
            ->appends($request->only([
                'search',
                'category_id',
                'price_min',
                'price_max',
                'sort',
                'condition',
                'is_negotiable',
                'is_featured',
                'per_page',
                'page'
            ]));

        $categories = ProductCategory::orderBy('name')->get();

        // If AJAX — return only the product grid wrapper (fragment) to be injected client-side
        if ($request->ajax()) {
            return view('frontend.products.partials.product-list-wrapper', compact('products'))->render();
        }

        // Regular full page render
        return view('frontend.products.index', [
            'products'     => $products,
            'categories'   => $categories,
            'filters'      => $request->only([
                'search',
                'category_id',
                'price_min',
                'price_max',
                'sort',
                'condition',
                'is_negotiable',
                'is_featured',
                'per_page'
            ]),
            'isSuperAdmin' => $isSuperAdmin,
        ]);
    }


    /**
     * Show the single‐product detail page.
     */
    public function show(Product $product)
    {
        return view('frontend.products.show', [
            'product' => $product->load(['images', 'seller', 'society', 'category']),
        ]);
    }
}
