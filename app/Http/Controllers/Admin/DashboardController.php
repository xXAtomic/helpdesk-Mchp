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
            'maintenance_pending' => Asset::where('next_maintenance_at', '<=', now()->addDays(7))->count(),
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

        // 📈 Carga de Trabajo de Técnicos
        $stats['tech_workload'] = User::whereHas('role', fn($q) => $q->whereIn('slug', ['admin', 'technician']))
            ->withCount(['assignedTickets' => fn($q) => $q->whereNull('closed_at')])
            ->orderBy('assigned_tickets_count', 'desc')
            ->take(5)
            ->get();

        // 🖥️ Salud del Inventario (Donut Chart)
        $stats['equipment_health'] = Asset::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTickets'));
    }
}
