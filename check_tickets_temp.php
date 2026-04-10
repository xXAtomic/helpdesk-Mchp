<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ticket;
use Carbon\Carbon;

$today = '2026-04-10'; // Hardcoded for today as per metadata
$tickets = Ticket::whereDate('created_at', $today)->get();

echo "Found " . $tickets->count() . " tickets created today (" . $today . ").\n";

foreach ($tickets as $ticket) {
    echo "ID: {$ticket->id} | Subject: {$ticket->subject}\n";
}
