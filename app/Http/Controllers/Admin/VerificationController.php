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

    public function toggleStatus(Request $request, User $user)
    {
        if ($user->account_status === 'approved') {
            $request->validate([
                'suspension_reason' => 'required|string|max:500'
            ]);

            $user->update([
                'account_status' => 'rejected',
                'suspension_reason' => $request->suspension_reason
            ]);
            
            if ($user->verification) {
                $user->verification->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->suspension_reason
                ]);
            }
            
            return back()->with('success', "Akun {$user->name} telah ditangguhkan.");
        } else {
            $user->update([
                'account_status' => 'approved',
                'suspension_reason' => null
            ]);
            
            if ($user->verification) {
                $user->verification->update([
                    'status' => 'approved',
                    'rejection_reason' => null
                ]);
            }
            
            return back()->with('success', "Akun {$user->name} telah diaktifkan kembali.");
        }
    }

    public function destroy(User $user)
    {
        if ($user->verification) {
            $user->verification->delete();
        }
        
        $userName = $user->name;
        $user->delete();

        return back()->with('success', "Akun {$userName} berhasil dihapus.");
    }

    public function getMessages(User $user)
    {
        $messages = \App\Models\SuspensionMessage::where('user_id', $user->id)->oldest()->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = \App\Models\SuspensionMessage::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'sender' => 'admin'
        ]);

        if ($request->ajax()) {
            return response()->json($message);
        }

        return back()->with('success', 'Respon berhasil dikirim.');
    }
}
