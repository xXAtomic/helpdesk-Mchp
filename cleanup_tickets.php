<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ticket;
use Illuminate\Support\Facades\Config;

// Try with 127.0.0.1 explicitly
Config::set('database.connections.mysql.host', '127.0.0.1');

try {
    $count = Ticket::whereDate('created_at', '2026-04-10')->count();
    echo "Tickets found: $count\n";
    if ($count > 0) {
        Ticket::whereDate('created_at', '2026-04-10')->delete();
        echo "Successfully deleted $count tickets.\n";
    }
} catch (\Exception $e) {
    echo "Connection error: " . $e->getMessage() . "\n";
}
