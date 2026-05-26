<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function notice()
    {
        $user = auth()->user();
        $verification = $user->verification;
        $messages = collect();
        if (!is_null($user->suspension_reason)) {
            $messages = \App\Models\SuspensionMessage::where('user_id', $user->id)->oldest()->get();
        }

        return view('verification.notice', compact('user', 'verification', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $user = auth()->user();

        if (is_null($user->suspension_reason)) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $message = \App\Models\SuspensionMessage::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'sender' => 'user'
        ]);

        if ($request->ajax()) {
            return response()->json($message);
        }

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function getMessages()
    {
        $user = auth()->user();
        if (is_null($user->suspension_reason)) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $messages = \App\Models\SuspensionMessage::where('user_id', $user->id)->oldest()->get();
        return response()->json($messages);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nib' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_izin' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'profil_seller' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();
        
        // Update data user
        $user->update([
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'account_status' => 'pending',
        ]);

        // Simpan file yang diunggah
        $ktpPath = $request->file('ktp')->store('verifications/ktp', 'public');
        $nibPath = $request->hasFile('nib') ? $request->file('nib')->store('verifications/nib', 'public') : null;
        $suratIzinPath = $request->hasFile('surat_izin') ? $request->file('surat_izin')->store('verifications/surat_izin', 'public') : null;
        $profilSellerPath = $request->hasFile('profil_seller') ? $request->file('profil_seller')->store('verifications/profil_seller', 'public') : null;

        UserVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'ktp_path' => $ktpPath,
                'nib_path' => $nibPath,
                'surat_izin_path' => $suratIzinPath,
                'profil_seller_path' => $profilSellerPath,
                'status' => 'pending',
                'rejection_reason' => null
            ]
        );

        return redirect()->route('verification.notice')->with('success', 'Data dan dokumen berhasil dikirim. Menunggu persetujuan admin.');
    }
}
