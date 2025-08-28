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
            ->withCount([
                'comments',
                'likedByUsers as likes_count'
            ])

            ->where('status', 'approved');

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
        $likedPostIds = $user->likedPosts()->pluck('post_id')->toArray();
        // Total approved count (scoped)
        $approvedCountQuery = Post::where('status', 'approved');
        if (! $user->hasRole('super_admin')) {
            $approvedCountQuery->where('society_id', $user->society_id);
        }
        $approvedCount = $approvedCountQuery->count();

        $recentPostsQuery = Post::where('status', 'approved')
            ->withCount('comments')
            ->orderByDesc('created_at');

        if (! $user->hasRole('super_admin')) {
            $recentPostsQuery->where('society_id', $user->society_id);
        }
        $recentPosts = $recentPostsQuery->take(6)->get();

        $categories = Category::orderBy('name')->get();
        $societies  = $user->hasRole('super_admin') ? Society::all() : collect();

        // If request is AJAX, return only the posts-grid partial (HTML)
        if ($request->ajax()) {
            return view('frontend.posts.partials.posts-grid', compact('posts'))->render();
        }

        // Normal full page render
        return view('frontend.posts.index', compact(
            'posts',
            'approvedCount',
            'categories',
            'societies',
            'recentPosts',
            'likedPostIds'
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
    public function update(Request $request, Post $post)
    {
        // Make sure only the owner (or super admin) can update
        if (auth()->id() !== $post->user_id && !auth()->user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'image'       => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Update fields
        $post->title       = $request->title;
        $post->body        = $request->body;
        $post->category_id = $request->category_id;

        // Reset status to pending when updated (so admins re-approve)
        if (!auth()->user()->hasRole('super_admin')) {
            $post->status = 'pending';
        }

        // Handle image
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
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
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($post->likedByUsers()->where('user_id', $user->id)->exists()) {
            // Unlike
            $post->likedByUsers()->detach($user->id);
            $liked = false;
        } else {
            // Like
            $post->likedByUsers()->attach($user->id);
            $liked = true;
        }

        return response()->json([
            'success'     => true,
            'liked'       => $liked,
            'likes_count' => $post->likedByUsers()->count(),
        ]);
    }
}
