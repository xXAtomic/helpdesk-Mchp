<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Asset;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BossDashboardController extends Controller
{
    public function index()
    {
        // 1. Total de tickets
        $ticketsCount = Ticket::count();

        // 2. Número de tickets cerrados TOTAL
        $resolvedCount = Ticket::whereHas('status', function($q) {
            $q->where('is_closed', true);
        })->count();

        // 2b. Tickets resueltos este mes (Contador Mensual)
        $monthlyResolvedCount = Ticket::whereHas('status', function($q) {
                $q->where('is_closed', true);
            })
            ->whereBetween('resolved_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        // 3. Número de equipos registrados en el inventario
        $equipmentCount = Asset::count();

        // 4. Tickets en proceso (En Progreso)
        $inProcessTickets = Ticket::whereHas('status', function($q) {
            $q->where('name', 'En Progreso');
        })->count();

        // 5. Tiempo de respuesta promedio (desde creación hasta resolución)
        $ticketsWithResolution = Ticket::whereNotNull('resolved_at')->get();
        if ($ticketsWithResolution->count() > 0) {
            $totalHours = $ticketsWithResolution->sum(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->resolved_at);
            });
            $avgResponseTime = round($totalHours / $ticketsWithResolution->count(), 1) . ' h';
        } else {
            $avgResponseTime = '0 h';
        }

        // Datos para gráficos (por ejemplo, tickets por categoría)
        $ticketsByCategory = DB::table('tickets')
            ->join('ticket_categories', 'tickets.category_id', '=', 'ticket_categories.id')
            ->select('ticket_categories.name', DB::raw('count(*) as total'))
            ->groupBy('ticket_categories.name')
            ->get();

        return view('boss.dashboard', compact(
            'ticketsCount', 
            'resolvedCount', 
            'monthlyResolvedCount',
            'equipmentCount', 
            'inProcessTickets', 
            'avgResponseTime',
            'ticketsByCategory'
        ));
    }
}
