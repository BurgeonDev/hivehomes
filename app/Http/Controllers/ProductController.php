<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        // require login for all frontend product actions
        $this->middleware('auth');
    }

    /**
     * Display a listing of approved products for the current user's society.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Product::query()
            ->approved()
            ->forSociety($user->society_id)
            ->with('primaryImage', 'seller', 'category')
            ->latest();

        // Filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $s = $request->get('search');
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', floatval($request->price_min));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', floatval($request->price_max));
        }

        if ($request->filled('negotiable')) {
            $query->where('is_negotiable', (bool) $request->negotiable);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('marketplace.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $product = new Product();

        return view('marketplace.form', [
            'product' => $product,
            'categories' => $categories,
            'method' => 'create'
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'condition' => ['required', Rule::in(['new', 'like_new', 'used', 'refurbished', 'other'])],
            'is_negotiable' => 'sometimes|boolean',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $data['user_id'] = $user->id;
        $data['society_id'] = $user->society_id;
        $data['is_negotiable'] = $request->has('is_negotiable') ? (bool)$request->is_negotiable : false;
        // always pending by default (admin will approve)
        $data['status'] = 'pending';

        DB::transaction(function () use (&$product, $data, $request) {
            $product = Product::create($data);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $idx => $img) {
                    $path = $img->store("products/{$product->id}", 'public');
                    $product->images()->create([
                        'path' => $path,
                        'order' => $idx,
                        'is_primary' => $idx === 0,
                    ]);
                }
            }
        });

        return redirect()->route('marketplace.show', $product)
            ->with('success', 'Product submitted for approval.');
    }

    /**
     * Display the specified product.
     */
    public function show(Request $request, Product $product)
    {
        $user = $request->user();

        // visibility: approved OR owner OR admin (society or super)
        if (
            $product->status !== 'approved'
            && $product->user_id !== $user->id
            && ! $this->isAdmin($user)
        ) {
            abort(403, 'Product not visible');
        }

        // increment views (optional)
        $product->increment('views');

        $product->load('images', 'seller', 'category');

        return view('marketplace.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Request $request, Product $product)
    {
        $this->authorizeOwnerOrAdmin($request->user(), $product);

        $categories = Category::orderBy('name')->get();

        return view('marketplace.form', [
            'product' => $product,
            'categories' => $categories,
            'method' => 'edit'
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeOwnerOrAdmin($request->user(), $product);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'condition' => ['required', Rule::in(['new', 'like_new', 'used', 'refurbished', 'other'])],
            'is_negotiable' => 'sometimes|boolean',
            'images.*' => 'nullable|image|max:5120',
            'remove_images' => 'sometimes|array',
            'remove_images.*' => 'integer|exists:product_images,id',
        ]);

        $data['is_negotiable'] = $request->has('is_negotiable') ? (bool)$request->is_negotiable : false;

        DB::transaction(function () use ($product, $data, $request) {
            // remove selected images (if any)
            if ($request->filled('remove_images')) {
                $toRemove = ProductImage::whereIn('id', $request->remove_images)
                    ->where('product_id', $product->id)
                    ->get();
                foreach ($toRemove as $img) {
                    Storage::disk('public')->delete($img->path);
                    $img->delete();
                }
            }

            // add new images (if any)
            if ($request->hasFile('images')) {
                $currentMax = $product->images()->max('order') ?? 0;
                foreach ($request->file('images') as $i => $img) {
                    $path = $img->store("products/{$product->id}", 'public');
                    $product->images()->create([
                        'path' => $path,
                        'order' => $currentMax + $i + 1,
                        'is_primary' => false,
                    ]);
                }
            }

            // if non-admin edits, send for re-approval
            if (! $this->isAdmin(request()->user())) {
                $data['status'] = 'pending';
            }

            $product->update($data);

            // ensure a primary image exists
            if (! $product->images()->where('is_primary', true)->exists()) {
                $first = $product->images()->orderBy('order')->first();
                if ($first) $first->update(['is_primary' => true]);
            }
        });

        return redirect()->route('marketplace.show', $product)->with('success', 'Product updated.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $this->authorizeOwnerOrAdmin($request->user(), $product);

        // delete images from storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('marketplace.index')->with('success', 'Product removed.');
    }

    /* ----------------- helpers ----------------- */

    protected function isAdmin($user)
    {
        return method_exists($user, 'hasRole') && ($user->hasRole('super_admin') || $user->hasRole('society_admin'));
    }

    protected function isSocietyAdmin($user)
    {
        return method_exists($user, 'hasRole') && $user->hasRole('society_admin');
    }

    protected function authorizeOwnerOrAdmin($user, Product $product)
    {
        if ($product->user_id !== $user->id && ! $this->isAdmin($user)) {
            abort(403);
        }
    }
}
