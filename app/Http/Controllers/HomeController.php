<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessageMail;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        // Save to DB
        $contact = Contact::create($request->only('name', 'email', 'phone', 'message'));

        // Queue the email instead of sending directly
        Mail::queue(new NewContactMessageMail($contact));

        return back()->with('success', 'Your message has been queued for sending!');
    }

    public function show($id)
    {
        $post = Post::with(['user', 'society'])->findOrFail($id);

        return view('frontend.posts.index', compact('post'));
    }
}
