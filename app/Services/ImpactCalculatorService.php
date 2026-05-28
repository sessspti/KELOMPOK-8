<?php

namespace App\Services;

use App\Models\EnvironmentalImpact;
use App\Models\Order;
use App\Models\User;

class ImpactCalculatorService
{
    private const DEFAULT_WEIGHT_PER_ITEM_KG = 0.5;
    private const CO2_PER_KG = 2.5;

    public function recalculateForUser(int $userId): void
    {
        $user = User::find($userId);
        if (! $user) {
            return;
        }

        $isSeller = $user->role === 'seller';

        $orders = $isSeller
            ? Order::with(['menu', 'user'])
                ->whereHas('menu', fn ($q) => $q->where('user_id', $userId))
                ->where('status', 'selesai')
                ->whereNotNull('transaction_id')
                ->get()
            : Order::with(['menu', 'user'])
                ->where('id_user', $userId)
                ->where('status', 'selesai')
                ->whereNotNull('transaction_id')
                ->get();

        $totalFoodKg = 0.0;
        $totalMoney = 0.0;

        foreach ($orders as $order) {
            if (! $order->menu) {
                continue;
            }

            $weightPerItem = (float) ($order->menu->weight_kg ?? self::DEFAULT_WEIGHT_PER_ITEM_KG);
            $foodKg = $order->quantity * $weightPerItem;
            $totalFoodKg += $foodKg;

            if (! $isSeller && $order->user && $order->user->role === 'konsumen') {
                $original = (float) $order->menu->price * $order->quantity;
                $rescue = (float) ($order->unit_price ?? $order->menu->final_price) * $order->quantity;
                $totalMoney += max(0, $original - $rescue);
            }
        }

        EnvironmentalImpact::updateOrCreate(
            ['user_id' => $userId],
            [
                'food_saved_kg' => round($totalFoodKg, 2),
                'co2_reduced_kg' => round($totalFoodKg * self::CO2_PER_KG, 2),
                'money_saved' => round($totalMoney, 2),
                'total_rescues' => $orders->count(),
            ]
        );
    }

    public function calculateFromOrder(Order $order): void
    {
        $order->loadMissing(['menu', 'user']);

        if (! $order->menu || ! $order->user) {
            return;
        }

        $this->recalculateForUser($order->user->id);

        if ($order->menu->user_id && $order->menu->user_id !== $order->user->id) {
            $this->recalculateForUser((int) $order->menu->user_id);
        }
    }

    /**
     * Sinkronkan dampak dari seluruh riwayat order berstatus selesai.
     */
    public function recalculateAll(): int
    {
        $buyerIds = Order::query()
            ->where('status', 'selesai')
            ->whereNotNull('transaction_id')
            ->distinct()
            ->pluck('id_user');

        $sellerIds = Order::query()
            ->where('orders.status', 'selesai')
            ->whereNotNull('orders.transaction_id')
            ->join('menus', 'menus.id', '=', 'orders.menu_id')
            ->distinct()
            ->pluck('menus.user_id');

        $userIds = $buyerIds->merge($sellerIds)->unique()->filter();

        foreach ($userIds as $userId) {
            $this->recalculateForUser((int) $userId);
        }

        return $userIds->count();
    }

    public function syncForUser(int $userId): EnvironmentalImpact
    {
        $this->recalculateForUser($userId);

        return EnvironmentalImpact::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Hitung dampak untuk satu baris order (untuk tampilan riwayat transaksi).
     */
    public function metricsForOrder(Order $order): array
    {
        $order->loadMissing(['menu', 'user']);

        if (! $order->menu || $order->status !== 'selesai') {
            return [
                'food_kg' => 0.0,
                'co2_kg' => 0.0,
                'money_saved' => 0.0,
                'counts' => false,
            ];
        }

        $weightPerItem = (float) ($order->menu->weight_kg ?? self::DEFAULT_WEIGHT_PER_ITEM_KG);
        $foodKg = $order->quantity * $weightPerItem;
        $moneySaved = 0.0;

        if ($order->user && $order->user->role === 'konsumen') {
            $original = (float) $order->menu->price * $order->quantity;
            $rescue = (float) ($order->unit_price ?? $order->menu->final_price) * $order->quantity;
            $moneySaved = max(0, $original - $rescue);
        }

        return [
            'food_kg' => round($foodKg, 2),
            'co2_kg' => round($foodKg * self::CO2_PER_KG, 2),
            'money_saved' => round($moneySaved, 2),
            'counts' => true,
        ];
    }

    /**
     * Agregasi dampak per invoice (transaction_id).
     */
    public function metricsForTransaction(string $transactionId, ?int $buyerUserId = null): array
    {
        $query = Order::with(['menu', 'user'])
            ->where('transaction_id', $transactionId)
            ->where('status', 'selesai');

        if ($buyerUserId) {
            $query->where('id_user', $buyerUserId);
        }

        $totals = ['food_kg' => 0.0, 'co2_kg' => 0.0, 'money_saved' => 0.0, 'counts' => false];

        foreach ($query->get() as $order) {
            $m = $this->metricsForOrder($order);
            if (! $m['counts']) {
                continue;
            }
            $totals['food_kg'] += $m['food_kg'];
            $totals['co2_kg'] += $m['co2_kg'];
            $totals['money_saved'] += $m['money_saved'];
            $totals['counts'] = true;
        }

        $totals['food_kg'] = round($totals['food_kg'], 2);
        $totals['co2_kg'] = round($totals['co2_kg'], 2);
        $totals['money_saved'] = round($totals['money_saved'], 2);

        return $totals;
    }
}
