<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{
    public function toggle(Request $request, $id)
    {
        $seller = User::findOrFail($id);

        if ($seller->role !== 'seller') {
            return response()->json(['success' => false, 'message' => 'Hanya bisa mengikuti seller.']);
        }

        if (auth()->id() == $id) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa mengikuti diri sendiri.']);
        }

        $existingFollow = Follow::where('follower_id', auth()->id())
                                ->where('followed_id', $id)
                                ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            $isFollowed = false;
        } else {
            Follow::create([
                'follower_id' => auth()->id(),
                'followed_id' => $id,
            ]);
            $isFollowed = true;
            
            // Kirim notifikasi ke seller
            $seller->notify(new \App\Notifications\GeneralNotification(
                "Pengikut Baru!",
                auth()->user()->name . " mulai mengikuti toko Anda.",
                "👋"
            ));
        }

        $followersCount = Follow::where('followed_id', $id)->count();

        return response()->json([
            'success' => true,
            'isFollowed' => $isFollowed,
            'followersCount' => $followersCount
        ]);
    }
}
