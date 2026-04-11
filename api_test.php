<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = config('services.gemini.key');
echo "Using Key: " . substr($key, 0, 5) . "...\n";

$result = Illuminate\Support\Facades\Http::withHeaders([
    'x-goog-api-key' => $key
])
// No SSL verify for local testing if needed
->withOptions(['verify' => false])
->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
    'contents' => [['parts' => [['text' => 'Hola']]]]
]);

echo "Status: " . $result->status() . "\n";
echo "Body:\n" . $result->body() . "\n";
