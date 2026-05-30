<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $transactions = App\Models\Order::with('menu')->where('id_user', 3)->whereNotNull('transaction_id')->where('status', '!=', 'pending')->select('transaction_id', 'payment_method', 'status', \Illuminate\Support\Facades\DB::raw('MIN(id) as id'), \Illuminate\Support\Facades\DB::raw('MIN(menu_id) as menu_id'), \Illuminate\Support\Facades\DB::raw('MAX(created_at) as date'), \Illuminate\Support\Facades\DB::raw('SUM(quantity * COALESCE(unit_price, (select ROUND(price - (price * discount / 100)) from menus where menus.id = orders.menu_id))) as total_price'))->groupBy('transaction_id', 'payment_method', 'status')->orderBy('date', 'desc')->get();
    echo json_encode($transactions->toArray());
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
