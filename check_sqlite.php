<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Ticket;

// Try to list tickets from SQLite if it exists
try {
    config(['database.default' => 'sqlite']);
    config(['database.connections.sqlite.database' => database_path('database.sqlite')]);
    
    $count = Ticket::whereDate('created_at', '2026-04-10')->count();
    echo "SQLite Count: $count\n";
    if ($count > 0) {
        Ticket::whereDate('created_at', '2026-04-10')->get()->each(function($t) {
            echo "ID: {$t->id} | Subject: {$t->title}\n";
        });
    }
} catch (\Exception $e) {
    echo "SQLite error: " . $e->getMessage() . "\n";
}
