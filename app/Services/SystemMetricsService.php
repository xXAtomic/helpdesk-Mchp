<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Asset;
use App\Models\TicketRating;
use App\Models\SupplyLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SystemMetricsService
{
    /**
     * Extrae las estadísticas operativas principales (Tickets, SLA, CSAT).
     */
    public function getOperativeMetrics()
    {
        $ticketsWithResolution = Ticket::whereNotNull('resolved_at')->get();
        $avgResponseTime = '0 h';
        
        if ($ticketsWithResolution->count() > 0) {
            $totalHours = $ticketsWithResolution->sum(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->resolved_at);
            });
            $avgResponseTime = round($totalHours / $ticketsWithResolution->count(), 1) . ' h';
        }

        return [
            'ticketsCount' => Ticket::count(),
            'resolvedCount' => Ticket::whereHas('status', fn($q) => $q->where('is_closed', true))->count(),
            'monthlyResolvedCount' => Ticket::whereHas('status', fn($q) => $q->where('is_closed', true))
                ->whereBetween('resolved_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'inProcessTickets' => Ticket::whereHas('status', fn($q) => $q->where('name', 'En Progreso'))->count(),
            'avgResponseTime' => $avgResponseTime,
            'avgRating' => round(TicketRating::avg('rating') ?? 0, 1),
            'equipmentCount' => Asset::count()
        ];
    }

    /**
     * Extrae las métricas financieras (Inversión, Compras, Consumo).
     */
    public function getFinancialMetrics()
    {
        return [
            'totalHardwareInvestment' => Asset::sum('purchase_cost') ?? 0,
            
            'totalMonthlyPurchases' => SupplyLog::where('action', 'RESTOCK')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->with('supply')->get()->sum(fn($log) => $log->quantity * ($log->supply->unit_cost ?? 0)),
                
            'totalMonthlyConsumptions' => SupplyLog::where('action', 'CONSUMPTION')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->with('supply')->get()->sum(fn($log) => $log->quantity * ($log->supply->unit_cost ?? 0)),
                
            'recentTransactions' => SupplyLog::latest()->with(['supply', 'user', 'admin'])->limit(10)->get()
        ];
    }

    /**
     * Configura y extrae los datos para renderizar los gráficos de la interfaz.
     */
    public function getChartData()
    {
        $days = [];
        $ticketsCreated = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->translatedFormat('D');
            $ticketsCreated[] = Ticket::whereDate('created_at', $date->toDateString())->count();
        }

        return [
            'statusStats' => [
                'Pendientes' => Ticket::whereHas('status', fn($q) => $q->where('name', 'Abierto'))->count(),
                'En Progreso' => Ticket::whereHas('status', fn($q) => $q->where('name', 'En Progreso'))->count(),
                'Resueltos' => Ticket::whereHas('status', fn($q) => $q->where('is_closed', true))->count(),
            ],
            'days' => $days,
            'ticketsCreated' => $ticketsCreated,
            'ticketsByDepartment' => DB::table('tickets')
                ->join('departments', 'tickets.department_id', '=', 'departments.id')
                ->select('departments.name', DB::raw('count(*) as total'))
                ->groupBy('departments.name')
                ->orderBy('total', 'desc')
                ->limit(8)
                ->get()
        ];
    }
}
