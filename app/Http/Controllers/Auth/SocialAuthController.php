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
                // Jika password masih null, berarti akun terbuat dari versi auth google sebelumnya yang belum lengkap
                if (is_null($user->password)) {
                    session(['google_user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]]);
                    return redirect()->route('google.role.form');
                }

                // Update provider if not set
                if (!$user->provider) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
                }
                Auth::login($user);
                
                // Redirect based on role
                if ($user->role === 'seller') {
                    return redirect()->intended(route('seller.dashboard', absolute: false));
                } elseif ($user->role === 'lembaga_sosial') {
                    return redirect()->intended(route('sosial.dashboard', absolute: false));
                }
                return redirect()->intended(route('dashboard', absolute: false));
            } else {
                // Simpan data Google ke session sementara
                session(['google_user' => [
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User ' . Str::random(5),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]]);

                return redirect()->route('google.role.form');
            }

        } catch (\Exception $e) {
            // SEMENTARA UNTUK DEBUG: tampilkan pesan error aslinya
            dd('Error di Socialite Callback:', $e->getMessage(), $e->getTraceAsString());
        }
    }

    /**
     * Tampilkan form untuk memilih role dan mengisi password.
     */
    public function showRoleForm()
    {
        if (!session()->has('google_user')) {
            return redirect()->route('login');
        }

        return view('auth.google.role-password');
    }

    /**
     * Proses penyimpanan role dan password untuk user baru dari Google.
     */
    public function storeRolePassword(\Illuminate\Http\Request $request)
    {
        if (!session()->has('google_user')) {
            return redirect()->route('login');
        }

        $request->validate([
            'role' => ['required', 'string', 'in:seller,konsumen,lembaga_sosial'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $googleUser = session('google_user');

        if (isset($googleUser['id'])) {
            // Update akun lama yang belum punya password/role valid
            $user = User::find($googleUser['id']);
            if ($user) {
                $user->update([
                    'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                    'role' => $request->role,
                    'provider' => $googleUser['provider'],
                    'provider_id' => $googleUser['provider_id'],
                ]);
            }
        } else {
            // Buat akun baru
            $user = User::create([
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'provider' => $googleUser['provider'],
                'provider_id' => $googleUser['provider_id'],
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => $request->role,
            ]);
        }

        session()->forget('google_user');

        if (isset($user)) {
            Auth::login($user);

            if ($user->role === 'seller') {
                return redirect()->route('seller.dashboard');
            } elseif ($user->role === 'lembaga_sosial') {
                return redirect()->route('sosial.dashboard');
            }
            
            return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }
}
