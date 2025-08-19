<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

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
        $contact->update([
            'admin_reply' => $request->admin_reply,
            'is_seen' => true,
        ]);
        return back()->with('success', 'Reply sent successfully.');
    }
}
