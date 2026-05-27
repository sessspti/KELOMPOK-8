<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalImpact;

class ImpactDashboardController extends Controller
{
    public function globalStats()
    {
        $stats = EnvironmentalImpact::selectRaw('
            COALESCE(SUM(food_saved_kg), 0) as total_food_kg,
            COALESCE(SUM(co2_reduced_kg), 0) as total_co2,
            COALESCE(SUM(money_saved), 0) as total_money,
            COALESCE(SUM(total_rescues), 0) as total_rescues,
            COUNT(*) as total_users
        ')->first();

        return response()->json([
            'total_food_kg' => round((float) $stats->total_food_kg, 2),
            'total_co2' => round((float) $stats->total_co2, 2),
            'total_money' => (int) $stats->total_money,
            'total_rescues' => (int) $stats->total_rescues,
            'total_users' => (int) $stats->total_users,
        ]);
    }
}
