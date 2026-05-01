<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     */
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Check if user already exists
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Update provider if not set
                if (!$user->provider) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
                }
                Auth::login($user);
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User ' . Str::random(5),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => null, // Pastikan nullable di database
                    'role' => 'konsumen_seller', // Disesuaikan dengan enum di tabel users
                ]);

                Auth::login($user);
            }

            return redirect()->intended(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            // SEMENTARA UNTUK DEBUG: tampilkan pesan error aslinya
            dd('Error di Socialite Callback:', $e->getMessage(), $e->getTraceAsString());
            
            // Kode asli untuk production:
            // return redirect('/login')->withErrors(['email' => 'Gagal login menggunakan ' . ucfirst($provider) . '. Silakan coba lagi.']);
        }
    }
}
