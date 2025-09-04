<?php

namespace App\Http\Controllers;

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

        // Send email to domain inbox (from .env MAIL_FROM_ADDRESS)
        Mail::raw($contact->message, function ($msg) use ($contact) {
            $msg->to(config('mail.from.address')) // uses MAIL_FROM_ADDRESS from .env
                ->subject('New Contact Message from ' . $contact->name)
                ->from(config('mail.from.address'), config('mail.from.name'));
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function show($id)
    {
        $post = Post::with(['user', 'society'])->findOrFail($id);

        return view('frontend.posts.index', compact('post'));
    }
}
