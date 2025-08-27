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
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Product::with(['seller', 'society', 'primaryImage', 'images'])->latest();

        // Restrict products for society admin
        if ($user->hasRole('society_admin')) {
            $query->where('society_id', $user->society_id);
        }

        // Super admin can see all societies
        $societies = $user->hasRole('super_admin') ? Society::all() : collect();
        $products   = $query->paginate(30);
        $categories = ProductCategory::all();

        // Define isSuperAdmin
        $isSuperAdmin = $user->hasRole('super_admin');

        // Product counts by status
        if ($isSuperAdmin) {
            $approvedCount   = Product::where('status', 'approved')->count();
            $unapprovedCount = Product::where('status', 'pending')->count();
            $rejectedCount   = Product::where('status', 'rejected')->count();
        } else {
            $approvedCount   = Product::where('status', 'approved')->where('society_id', $user->society_id)->count();
            $unapprovedCount = Product::where('status', 'pending')->where('society_id', $user->society_id)->count();
            $rejectedCount   = Product::where('status', 'rejected')->where('society_id', $user->society_id)->count();
        }

        return view('admin.products.index', compact(
            'products',
            'categories',
            'societies',
            'approvedCount',
            'unapprovedCount',
            'rejectedCount'
        ));
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
            'images'         => 'nullable|array',
            'images.*'       => 'file|image|max:2048', // 2MB
        ]);

        $data['society_id'] = $request->user()->hasRole('super_admin')
            ? $request->input('society_id')
            : $request->user()->society_id;
        $data['user_id'] = $request->user()->id;

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
            'status'         => 'required|in:pending,approved,rejected',
            'images'         => 'nullable|array',
            'images.*'       => 'file|image|max:2048',
            'delete_images'  => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id',
        ]);

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
    public function updateStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Product status updated.']);
    }
}
