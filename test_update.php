<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
echo "Before: " . json_encode($user->only(['phone_number', 'address', 'city'])) . "\n";

$request = new \Illuminate\Http\Request();
$request->merge([
    'name' => 'Test Name',
    'email' => $user->email,
    'phone_number' => '081234567890',
    'address' => 'Test Address',
    'city' => 'jakarta',
]);

// Let's directly call the controller logic manually
$data = $request->only(['name', 'email', 'phone_number', 'address', 'city']);
$user->fill($data);
$user->save();

echo "After: " . json_encode($user->fresh()->only(['phone_number', 'address', 'city'])) . "\n";
