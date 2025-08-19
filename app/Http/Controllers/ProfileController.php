<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validated();

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            // Delete old if exists
            if ($user->profile_pic && \Storage::disk('public')->exists($user->profile_pic)) {
                \Storage::disk('public')->delete($user->profile_pic);
            }

            $path = $request->file('profile_pic')->store('profile_pictures', 'public');
            $data['profile_pic'] = $path;
        }

        // Reset email verification if email changed
        if ($data['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->update($data);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
