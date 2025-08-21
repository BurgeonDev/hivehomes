<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query: only approved posts
        $query = Post::with(['user', 'category', 'society'])
            ->withCount('comments')
            ->where('status', 'approved');

        // Scope to user's society if not super admin
        if (! $user->hasRole('super_admin')) {
            $query->where('society_id', $user->society_id);
        }

        // Search (title or body)
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', '%' . $q . '%')
                    ->orWhere('body', 'like', '%' . $q . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'most_viewed') {
            $query->orderByDesc('views');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderByDesc('created_at'); // latest
        }

        // Paginate and preserve query string
        $posts = $query->paginate(9)->withQueryString();

        // Total approved count (scoped)
        $approvedCountQuery = Post::where('status', 'approved');
        if (! $user->hasRole('super_admin')) {
            $approvedCountQuery->where('society_id', $user->society_id);
        }
        $approvedCount = $approvedCountQuery->count();
        // add after your $approvedCount, before returning view:
        $recentPostsQuery = Post::where('status', 'approved')
            ->withCount('comments')
            ->orderByDesc('created_at');

        if (! $user->hasRole('super_admin')) {
            $recentPostsQuery->where('society_id', $user->society_id);
        }

        $recentPosts = $recentPostsQuery->take(6)->get();

        $categories = Category::orderBy('name')->get();
        $societies  = $user->hasRole('super_admin') ? Society::all() : collect();

        return view('frontend.posts.index', compact(
            'posts',
            'approvedCount',
            'categories',
            'societies',
            'recentPosts'
        ));
    }

    public function store(Request $request)
    {
        // unchanged
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'image'       => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only(['title', 'body', 'category_id']);
        $data['user_id'] = auth()->id();

        if (auth()->user()->hasRole('super_admin')) {
            $data['society_id'] = $request->input('society_id');
        } else {
            $data['society_id'] = auth()->user()->society_id;
        }

        $data['status'] = 'pending'; // posts still go to pending for admin review

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post submitted for review.');
    }

    public function show($id)
    {
        $user = Auth::user();

        $post = Post::with(['user', 'category', 'society', 'comments'])->findOrFail($id);

        // Only allow show if the post is approved (public) or the viewer is admin of that society or super_admin
        if ($post->status !== 'approved') {
            if (
                ! $user->hasRole('super_admin') &&
                ! ($user->hasRole('society_admin') && $user->society_id === $post->society_id)
            ) {
                abort(403, 'You are not allowed to view this post.');
            }
        } else {
            if (! $user->hasRole('super_admin') && $user->society_id !== $post->society_id) {
                abort(403, 'You are not allowed to view this post.');
            }
        }

        // increment simple view counter
        $post->increment('views');

        return view('frontend.posts.show', compact('post'));
    }
}
