<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Exception;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        try {
            return view('profile.edit', [
                'user' => $request->user(),
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', 'Failed to load profile edit page.');
        }
    }

    /**
     * Display the user's profile view.
     */
    public function show(Request $request): View|RedirectResponse
    {
        try {
            return view('frontend.profile.show', [
                'user' => $request->user(),
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', 'Failed to load profile view.');
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                    Storage::disk('public')->delete($user->profile_pic);
                }

                $path = $request->file('profile_pic')->store('profile_pictures', 'public');
                $data['profile_pic'] = $path;
            }

            // Reset email verification if email changed
            if ($data['email'] !== $user->email) {
                $user->email_verified_at = null;
            }

            $user->update($data);

            return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
        } catch (Exception $e) {
            return Redirect::back()->with('error', 'Failed to update profile. ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('success', 'Your account has been deleted.');
        } catch (Exception $e) {
            return Redirect::back()->with('error', 'Failed to delete account. ' . $e->getMessage());
        }
    }
}
