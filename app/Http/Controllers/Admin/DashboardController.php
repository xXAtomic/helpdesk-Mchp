<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Asset;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas Base
        $stats = [
            'total_tickets'   => Ticket::count(),
            'open_tickets'    => Ticket::whereNull('closed_at')->count(),
            'total_equipment' => Asset::count(),
            'total_users'     => User::count(),
        ];

        // Distribución por Estatus ✨
        $stats['by_status'] = \DB::table('tickets')
            ->join('ticket_statuses', 'tickets.status_id', '=', 'ticket_statuses.id')
            ->select('ticket_statuses.name', 'ticket_statuses.color', \DB::raw('count(*) as total'))
            ->groupBy('ticket_statuses.name', 'ticket_statuses.color')
            ->get();

        // Distribución por Prioridad ✨
        $stats['by_priority'] = \DB::table('tickets')
            ->join('ticket_priorities', 'tickets.priority_id', '=', 'ticket_priorities.id')
            ->select('ticket_priorities.name', 'ticket_priorities.color', \DB::raw('count(*) as total'))
            ->groupBy('ticket_priorities.name', 'ticket_priorities.color')
            ->get();

        // Volumen Semanal ✨
        $stats['weekly_volume'] = Ticket::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Últimos 5 tickets para la tabla de actividad
        $recentTickets = Ticket::with(['user', 'status', 'priority'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentTickets'));
    }
}
