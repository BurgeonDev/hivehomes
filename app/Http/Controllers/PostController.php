<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Start the query
        $query = Post::with(['user', 'category']);

        // Handle 'pending' and 'approved' filters
        if ($request->filter === 'pending' && ($user->hasRole('super_admin') || $user->hasRole('society_admin'))) {
            $query->where('status', 'pending');
            if (! $user->hasRole('super_admin')) {
                $query->where('society_id', $user->society_id);
            }
        } else {
            $query->where('status', 'approved');
            if (! $user->hasRole('super_admin')) {
                $query->where('society_id', $user->society_id);
            }
        }

        // Category filtering
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->latest()->paginate(9);

        $approvedCount = Post::where('status', 'approved')
            ->when(!$user->hasRole('super_admin'), fn($q) => $q->where('society_id', $user->society_id))
            ->count();

        $pendingCount = Post::where('status', 'pending')
            ->when(!$user->hasRole('super_admin'), fn($q) => $q->where('society_id', $user->society_id))
            ->count();

        $categories = Category::orderBy('name')->get();

        return view('frontend.posts.index', compact(
            'posts',
            'approvedCount',
            'pendingCount',
            'categories'
        ));
    }



    public function create()
    {
        $categories = Category::all();
        return view('frontend.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only(['title', 'description', 'category_id']);
        $data['user_id'] = auth()->id();
        $data['society_id'] = auth()->user()->society_id;
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Post submitted for review.');
    }

    public function show($id)
    {
        $post = Post::with(['user', 'category', 'society'])
            ->where('status', 'approved')
            ->findOrFail($id);

        return view('frontend.posts.show', compact('post'));
    }
}
