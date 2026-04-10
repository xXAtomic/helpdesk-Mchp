<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Asset;
use App\Models\TicketStatus;
use App\Models\TicketRating;
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

        // 6. Calificación promedio de satisfacción (CSAT)
        $avgRating = TicketRating::avg('rating') ?? 0;
        $avgRating = round($avgRating, 1);

        // 7. Datos para Gráfico de Dona (Estados Reales)
        $statusStats = [
            'Pendientes' => Ticket::whereHas('status', fn($q) => $q->where('name', 'Abierto'))->count(),
            'En Progreso' => Ticket::whereHas('status', fn($q) => $q->where('name', 'En Progreso'))->count(),
            'Resueltos' => Ticket::whereHas('status', fn($q) => $q->where('is_closed', true))->count(),
        ];

        // 8. Datos para Gráfico de Tendencia (Últimos 7 días)
        $days = [];
        $ticketsCreated = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->translatedFormat('D');
            $ticketsCreated[] = Ticket::whereDate('created_at', $date->toDateString())->count();
        }

        $ticketsByDepartment = DB::table('tickets')
            ->join('departments', 'tickets.department_id', '=', 'departments.id')
            ->select('departments.name', DB::raw('count(*) as total'))
            ->groupBy('departments.name')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get();

        // 9. Datos Financieros Detallados ✨
        $totalHardwareInvestment = Asset::sum('purchase_cost') ?? 0;

        // Compras de Stock (Entradas - RESTOCK)
        $totalMonthlyPurchases = \App\Models\SupplyLog::where('action', 'RESTOCK')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('supply')
            ->get()
            ->sum(function($log) {
                return $log->quantity * ($log->supply->unit_cost ?? 0);
            });

        // Gasto Operativo (Salidas - CONSUMPTION)
        $totalMonthlyConsumptions = \App\Models\SupplyLog::where('action', 'CONSUMPTION')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('supply')
            ->get()
            ->sum(function($log) {
                return $log->quantity * ($log->supply->unit_cost ?? 0);
            });

        // 10. Listado para Auditoría (Últimos 10 movimientos)
        $recentTransactions = \App\Models\SupplyLog::latest()
            ->with(['supply', 'user', 'admin'])
            ->limit(10)
            ->get();

        return view('boss.dashboard', compact(
            'ticketsCount', 
            'resolvedCount', 
            'monthlyResolvedCount',
            'equipmentCount', 
            'inProcessTickets', 
            'avgResponseTime',
            'avgRating',
            'statusStats',
            'days',
            'ticketsCreated',
            'ticketsByDepartment',
            'totalHardwareInvestment',
            'totalMonthlyPurchases',
            'totalMonthlyConsumptions',
            'recentTransactions'
        ));
    }

    public function reports()
    {
        // Generamos un histórico de los últimos 12 meses
        $history = [];
        
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            $monthName = $date->translatedFormat('F Y');

            // 1. Tickets
            $created = Ticket::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $resolved = Ticket::whereMonth('resolved_at', $month)->whereYear('resolved_at', $year)->count();

            // 2. Inversión Hardware (Basado en fecha de creación del registro del activo)
            $hardwareInvestment = Asset::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('purchase_cost') ?? 0;

            // 3. Gasto Operativo (Insumos consumidos)
            $operationExpense = \App\Models\SupplyLog::where('action', 'CONSUMPTION')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->with('supply')
                ->get()
                ->sum(function($log) {
                    return $log->quantity * ($log->supply->unit_cost ?? 0);
                });

            // Solo agregamos si hubo actividad para no llenar de ceros
            if ($created > 0 || $resolved > 0 || $hardwareInvestment > 0 || $operationExpense > 0) {
                $history[] = [
                    'month_name' => $monthName,
                    'created' => $created,
                    'resolved' => $resolved,
                    'investment' => $hardwareInvestment,
                    'expense' => $operationExpense,
                    'csat' => round(TicketRating::whereMonth('created_at', $month)->whereYear('created_at', $year)->avg('rating') ?? 0, 1)
                ];
            }
        }

        return view('boss.reports', compact('history'));
    }
}
