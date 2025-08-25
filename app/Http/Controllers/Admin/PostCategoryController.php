<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.post_categories.index', compact('categories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('admin.post-categories.index')->with('success', 'Category created successfully.');
    }


    public function update(Request $request, Category $post_category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $post_category->id,
        ]);

        $post_category->update($request->only('name'));

        return redirect()->route('admin.post-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $post_category)
    {
        $post_category->delete();
        return redirect()->route('admin.post-categories.index')->with('success', 'Category deleted successfully.');
    }
}
