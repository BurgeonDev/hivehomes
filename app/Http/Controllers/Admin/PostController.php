<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;
use App\Models\Society;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;


class PostController extends Controller
{

    public function index()
    {
        $posts      = Post::with('user', 'society', 'category')->latest()->get();
        $categories = Category::all();
        $societies  = auth()->user()->hasRole('super_admin')
            ? Society::all()
            : collect();
        return view('admin.posts.index', compact('posts', 'categories', 'societies'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        // society_id comes from form (select for SA, hidden otherwise)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('posts', 'public');
        }
        Post::create($data);
        return redirect()->route('admin.posts.index')->with('success', 'Post created!');
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Only attempt to delete if $post->image is a non-empty string
            if (!empty($post->image) && is_string($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated!');
    }


    // New: inline status update
    public function changeStatus(Request $request, Post $post)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected,expired']);
        $post->update(['status' => $request->status]);
        return back()->with('success', 'Status updated.');
    }
}
