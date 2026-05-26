<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Menampilkan daftar kontak/percakapan
     */
    public function index()
    {
        $userId = auth()->id();

        // Ambil semua pesan di mana user terlibat (sebagai pengirim atau penerima)
        // Kelompokkan berdasarkan kontak untuk menampilkan inbox
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        // Mengelompokkan berdasarkan user lain
        $contacts = collect();
        foreach ($messages as $msg) {
            $otherUser = $msg->sender_id == $userId ? $msg->receiver : $msg->sender;
            
            if (!$contacts->has($otherUser->id)) {
                // Cari jumlah pesan belum dibaca dari kontak ini
                $unreadCount = Message::where('sender_id', $otherUser->id)
                                      ->where('receiver_id', $userId)
                                      ->where('is_read', false)
                                      ->count();

                $contacts->put($otherUser->id, (object)[
                    'user' => $otherUser,
                    'last_message' => $msg,
                    'unread_count' => $unreadCount
                ]);
            }
        }

        return view('chat.index', compact('contacts'));
    }

    /**
     * Menampilkan percakapan dengan satu user
     */
    public function show($otherUserId)
    {
        $userId = auth()->id();
        $otherUser = User::findOrFail($otherUserId);

        // Tandai semua pesan dari otherUser ke userId sebagai terbaca
        Message::where('sender_id', $otherUserId)
               ->where('receiver_id', $userId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        // Ambil percakapan
        $messages = Message::where(function($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $userId)->where('receiver_id', $otherUserId);
            })
            ->orWhere(function($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('messages', 'otherUser'));
    }

    /**
     * Kirim pesan baru
     */
    public function store(Request $request, $otherUserId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $otherUser = User::findOrFail($otherUserId);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $otherUserId,
            'message' => $request->message,
            'is_read' => false
        ]);

        // Kirim Notifikasi
        $senderName = auth()->user()->name;
        $otherUser->notify(new \App\Notifications\GeneralNotification(
            "Pesan Baru dari {$senderName}",
            "{$senderName}: " . \Illuminate\Support\Str::limit($request->message, 50),
            "💬"
        ));

        return redirect()->route('chat.show', $otherUserId);
    }
}
