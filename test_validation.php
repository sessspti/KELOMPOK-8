<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = \Illuminate\Http\Request::create('/profile', 'PATCH', [
    'name' => 'Test Name',
    'email' => 'test@example.com',
    'phone_number' => '081234567890',
    'address' => 'Test Address',
    'city' => 'jakarta',
]);

$formRequest = \App\Http\Requests\ProfileUpdateRequest::createFrom($request);
// Mock the user on the request
$user = App\Models\User::first();
$formRequest->setUserResolver(function () use ($user) {
    return $user;
});

// Since we're not running through standard routing, we manually trigger validation
$validator = app('validator')->make($formRequest->all(), $formRequest->rules());

if ($validator->fails()) {
    echo "Validation failed: " . json_encode($validator->errors()) . "\n";
} else {
    echo "Validation passed!\n";
    $safe = $validator->validated();
    echo "Validated data: " . json_encode($safe) . "\n";
}
