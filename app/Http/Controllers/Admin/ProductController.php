<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show all products (for super-admin or filtered to society_admin)
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Product::with(['seller', 'society', 'primaryImage'])->latest();

        if ($user->hasRole('society_admin')) {
            $query->where('society_id', $user->society_id);
        }
        $societies  = auth()->user()->hasRole('super_admin')
            ? Society::all()
            : collect();
        $products   = $query->paginate(30);
        $categories = ProductCategory::all();

        return view('admin.products.index', compact('products', 'categories', 'societies'));
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
            'status'         => 'required|in:pending,approved,rejected',
            'images.*'       => 'nullable|image|max:2048',
        ]);

        if ($request->user()->hasRole('super_admin')) {
            // take from the form
            $data['society_id'] = $request->input('society_id');
        } else {
            // force from logged in user's society
            $data['society_id'] = $request->user()->society_id;
        }
        $data['user_id']    = $request->user()->id;

        $product = Product::create($data);

        // Handle images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $idx => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path'       => $path,
                    'order'      => $idx,
                    'is_primary' => $idx === 0,
                ]);
            }
        }

        return back()->with('success', 'Product added.');
    }

    // Update an existing product
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
            'status'         => 'required|in:pending,approved,rejected',
            'images.*'       => 'nullable|image|max:2048',
        ]);

        $product->update($data);

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
