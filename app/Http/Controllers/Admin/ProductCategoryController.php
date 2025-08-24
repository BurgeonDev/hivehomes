<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::orderBy('name')->paginate(20);
        return view('admin.product_categories.index', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:product_categories,name',
            'slug' => 'nullable|string|max:150|unique:product_categories,slug',
            'description' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        ProductCategory::create($data);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category created.');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:product_categories,name,' . $productCategory->id,
            'slug' => 'nullable|string|max:150|unique:product_categories,slug,' . $productCategory->id,
            'description' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $productCategory->update($data);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // Prevent deletion if there are products in this category (safe guard)
        if ($productCategory->products()->exists()) {
            return redirect()->back()->with('error', 'Category cannot be deleted — it contains products.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category deleted.');
    }
}
