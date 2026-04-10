<?php
define('LARAVEL_START', microtime(true));
require '/var/www/ticket-system/vendor/autoload.php';
$app = require_once '/var/www/ticket-system/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ticket;
use Carbon\Carbon;

$today = '2026-04-10';
$count = Ticket::whereDate('created_at', $today)->count();

if ($count > 0) {
    Ticket::whereDate('created_at', $today)->delete();
    echo "Successfully deleted $count tickets created today ($today) on the server.\n";
} else {
    echo "No tickets found for today ($today) on the server.\n";
}
