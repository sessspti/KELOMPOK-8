<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
    public function sendMass(Request $request)
    {
        $request->validate([
            'role' => 'required|in:semua,konsumen,seller,lembaga_sosial',
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $query = \App\Models\User::query();
        if ($request->role !== 'semua') {
            $query->where('role', $request->role);
        } else {
            $query->where('role', '!=', 'admin');
        }

        $users = $query->get();
        \Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\GeneralNotification($request->title, $request->message));

        return back()->with('success', 'Notifikasi massal berhasil dikirim ke ' . $users->count() . ' pengguna.');
    }
}
