<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactMessage;

class HomeController extends Controller
{
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Store contact message
        $contact = Contact::create($request->only('name', 'email', 'message'));

        // Notify super admin (or you can loop through all admins if needed)
        $adminUser = User::role('super_admin')->first();
        if ($adminUser) {
            $adminUser->notify(new NewContactMessage($contact));
        }

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
