<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'approvedCount' => Product::where('status', 'approved')->count(),
            'societies' => Society::all()
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

    // Store a new product
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:product_categories,id',
            'price'          => 'nullable|numeric|min:0',
            'quantity'       => 'required|integer|min:1',
            'condition'      => 'required|in:new,like_new,used,refurbished,other',
            'is_negotiable'  => 'sometimes|boolean',
            'is_featured'    => 'sometimes|boolean',
            'featured_until' => 'nullable|date',
            'images'         => 'nullable|array',
            'images.*'       => 'file|image|max:2048', // 2MB
        ]);

        $data['society_id'] = $request->user()->hasRole('super_admin')
            ? $request->input('society_id')
            : $request->user()->society_id;
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending'; // always set to pending
        $product = Product::create($data);

        // handle files safely and report errors if any
        $errors = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $idx => $file) {
                if (!$file || !$file->isValid()) {
                    $errors[] = "Image at index {$idx} failed to upload. Error code: " . ($file ? $file->getError() : 'none');
                    continue;
                }
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path'       => $path,
                    'order'      => $idx,
                    'is_primary' => $idx === 0,
                ]);
            }
        }

        if (!empty($errors)) {
            // rollback created product and uploaded files to avoid partial state
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
            $product->delete();

            return back()->withErrors(['images' => $errors])->withInput();
        }

        return back()->with('success', 'Product added.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:product_categories,id',
            'price'          => 'nullable|numeric|min:0',
            'quantity'       => 'required|integer|min:1',
            'condition'      => 'required|in:new,like_new,used,refurbished,other',
            'is_negotiable'  => 'sometimes|boolean',
            'is_featured'    => 'sometimes|boolean',
            'featured_until' => 'nullable|date',
            'images'         => 'nullable|array',
            'images.*'       => 'file|image|max:2048',
            'delete_images'  => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id',
        ]);
        // Again, enforce same society logic
        $data['society_id'] = $request->user()->hasRole('super_admin')
            ? $request->input('society_id', $product->society_id)
            : $request->user()->society_id;

        // Enforce 'pending' status (or skip this if only for new submissions)
        $data['status'] = 'pending';
        $product->update($data);

        // delete selected images (single pass)
        if ($request->filled('delete_images')) {
            $toDelete = $product->images()->whereIn('id', $request->delete_images)->get();
            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // add new images safely
        $errors = [];
        if ($request->hasFile('images')) {
            // determine current last order index so we append new images
            $lastOrder = $product->images()->max('order');
            $lastOrder = is_null($lastOrder) ? -1 : (int)$lastOrder;

            foreach ($request->file('images') as $idx => $file) {
                if (!$file || !$file->isValid()) {
                    $errors[] = "Image at index {$idx} failed to upload. Error code: " . ($file ? $file->getError() : 'none');
                    continue;
                }
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path'       => $path,
                    'order'      => ++$lastOrder,
                    'is_primary' => !$product->images()->where('is_primary', 1)->exists() && $lastOrder === 0,
                ]);
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['images' => $errors])->withInput();
        }

        return back()->with('success', 'Product updated.');
    }
    // Delete a product (and its images)
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user->hasRole('society_admin') && $product->society_id !== $user->society_id) {
            abort(403);
        }

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $product->delete();

        return back()->with('success', 'Product removed.');
    }
}
