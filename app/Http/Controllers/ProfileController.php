<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        // Menggunakan method validated() agar lebih aman dan kompatibel
        $validatedData = $request->validated();
        
        // Buang avatar dari array jika ada, karena avatar ditangani secara khusus
        if (array_key_exists('avatar', $validatedData)) {
            unset($validatedData['avatar']);
        }

        // Mass assignment data yang sudah tervalidasi
        $request->user()->fill($validatedData);

        if ($request->hasFile('avatar')) {
            if ($request->user()->avatar) {
                Storage::disk('public')->delete($request->user()->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $avatarPath;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
