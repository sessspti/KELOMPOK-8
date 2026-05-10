<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function sync(Request $request)
    {
        $cart = $request->input('cart', []);
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Simple sync logic: 
        // 1. Remove existing pending orders for this user to avoid duplicates 
        // (Or update them if you want more complex logic, but this is 'standard' for a quick sync)
        Order::where('id_user', $userId)->where('status', 'pending')->delete();

        foreach ($cart as $item) {
            Order::create([
                'id_user' => $userId,
                'menu_id' => $item['id'],
                'quantity' => $item['qty'],
                'status' => 'pending',
            ]);
        }

        return response()->json(['success' => true]);
    }
}
