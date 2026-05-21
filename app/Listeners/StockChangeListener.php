<?php

namespace App\Listeners;

use App\Models\Menu;
use Illuminate\Support\Facades\Log;

class StockChangeListener
{
    public function handle($event)
    {
        $product = $event->product ?? $event->menu ?? null;
        
        if (!$product) {
            return;
        }
        
        // Log untuk debugging
        Log::info('Stock changed', [
            'product_id' => $product->id,
            'new_stock' => $product->stock,
            'is_visible' => $product->is_visible
        ]);
        
        // Can add notification logic here if needed
    }
}