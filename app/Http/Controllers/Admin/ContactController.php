<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{


    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate(['admin_reply' => 'required|string']);

        $adminReply = $request->admin_reply;

        try {
            // send reply email to the user
            Mail::send([], [], function ($message) use ($contact, $adminReply) {
                $message->to($contact->email)
                    ->subject('Reply from ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo(config('mail.from.address'), config('mail.from.name'))
                    ->html($adminReply); // ✅ correct method for HTML body

                // Optional: BCC to your domain inbox so you see a copy
                $message->bcc(config('mail.from.address'));
            });

            // Save reply in DB
            $contact->update([
                'admin_reply' => $adminReply,
                'is_seen' => true,
            ]);

            return back()->with('success', 'Reply sent successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to send contact reply: ' . $e->getMessage());
            return back()->with('error', 'Reply could not be sent — check mail settings or logs.');
        }
    }
}
