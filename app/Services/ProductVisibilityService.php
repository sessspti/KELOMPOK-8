<?php

namespace App\Services;

use App\Models\Menu;

class ProductVisibilityService
{
    /**
     * Get products visible for consumer dashboard
     */
    public function getVisibleProductsForConsumer()
    {
        return Menu::visibleForPublic()
            ->with('user:id,name,is_open,account_status')
            ->latest()
            ->get();
    }
    
    /**
     * Get products visible for institution dashboard
     */
    public function getVisibleProductsForInstitution()
    {
        return Menu::visibleForPublic()
            ->with('user:id,name,is_open,account_status')
            ->latest()
            ->get();
    }
    
    /**
     * Get all products for seller dashboard (including out-of-stock)
     */
    public function getAllProductsForSeller($sellerId)
    {
        return Menu::where('user_id', $sellerId)
            ->with('user:id,name,is_open,account_status')
            ->latest()
            ->get();
    }
    
    /**
     * Check and update product visibility after stock change
     */
    public function checkVisibilityAfterStockChange(Menu $product)
    {
        // Can be used for caching or notification logic
        return $product->is_visible;
    }
}