<?php
define('LARAVEL_START', microtime(true));
require '/var/www/ticket-system/vendor/autoload.php';
$app = require_once '/var/www/ticket-system/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ticket;

// Delete tickets from April 9th and 10th
$dates = ['2026-04-09', '2026-04-10'];
$totalDeleted = 0;

foreach ($dates as $date) {
    $count = Ticket::whereDate('created_at', $date)->count();
    if ($count > 0) {
        Ticket::whereDate('created_at', $date)->delete();
        $totalDeleted += $count;
        echo "Deleted $count tickets from $date.\n";
    }
}

echo "Total deleted: $totalDeleted\n";
