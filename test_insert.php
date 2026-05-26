<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $review = \App\Models\Review::create([
        'user_id' => 3, // dummy user
        'menu_id' => 2,
        'rating' => 5,
        'comment' => 'test review',
        'photo_path' => null,
    ]);
    echo "Success: " . $review->id;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
