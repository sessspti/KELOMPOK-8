<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    public function approve(User $user)
    {
        $verification = $user->verification;
        
        if ($verification) {
            $verification->update(['status' => 'approved']);
        }
        
        $user->update(['account_status' => 'approved']);

        return back()->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $verification = $user->verification;
        
        if ($verification) {
            $verification->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason
            ]);
        }
        
        $user->update(['account_status' => 'rejected']);

        return back()->with('success', "Pendaftaran akun {$user->name} ditolak.");
    }
}
