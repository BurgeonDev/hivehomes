<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:society_admin|super_admin']);
    }

    // pending for approval (society admin sees only their society)
    public function pending(Request $request)
    {
        $user = $request->user();
        $query = Product::where('status', 'pending')->with('seller', 'society', 'primaryImage')->latest();

        if ($user->hasRole('society_admin')) {
            $query->where('society_id', $user->society_id);
        }

        $products = $query->paginate(20);
        return view('marketplace.admin.pending', compact('products'));
    }

    // approve
    public function approve(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user->hasRole('society_admin') && $product->society_id !== $user->society_id) {
            abort(403);
        }

        $product->update(['status' => 'approved']);
        return back()->with('success', 'Product approved.');
    }

    // reject with optional reason
    public function reject(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user->hasRole('society_admin') && $product->society_id !== $user->society_id) {
            abort(403);
        }

        $product->update(['status' => 'rejected']);
        // optionally store reason: $request->validate(['reason'=>'nullable|string']);
        return back()->with('success', 'Product rejected.');
    }

    // admin index (all products)
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Product::with('seller', 'society', 'primaryImage')->latest();
        if ($user->hasRole('society_admin')) $query->where('society_id', $user->society_id);
        $products = $query->paginate(30);
        return view('marketplace.admin.index', compact('products'));
    }

    // optional: admin destroy
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user->hasRole('society_admin') && $product->society_id !== $user->society_id) abort(403);
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $product->delete();
        return back()->with('success', 'Product removed.');
    }
}
