<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
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
            // Queue the email instead of sending immediately
            Mail::to($contact->email)
                ->bcc(config('mail.from.address'))
                ->queue(new ContactReplyMail($contact, $adminReply));

            // Save reply in DB
            $contact->update([
                'admin_reply' => $adminReply,
                'is_seen' => true,
            ]);

            return back()->with('success', 'Reply has been queued to send.');
        } catch (\Throwable $e) {
            Log::error('Failed to queue contact reply: ' . $e->getMessage());
            return back()->with('error', 'Reply could not be queued — check mail settings or logs.');
        }
    }
}
