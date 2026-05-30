<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menu = \App\Models\Menu::withAvg('reviews', 'rating')->withCount('reviews')->first();
if ($menu) {
    echo json_encode($menu->toArray(), JSON_PRETTY_PRINT);
} else {
    echo "No menu found";
}
