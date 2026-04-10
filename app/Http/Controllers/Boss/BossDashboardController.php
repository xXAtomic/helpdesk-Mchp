<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Ticket;
use App\Models\TicketRating;
use App\Services\SystemMetricsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BossDashboardController extends Controller
{
    private $metricsService;

    public function __construct(SystemMetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    public function index()
    {
        // Centralización táctica: Delegamos el cálculo pesado al servicio
        $metrics = array_merge(
            $this->metricsService->getOperativeMetrics(),
            $this->metricsService->getFinancialMetrics(),
            $this->metricsService->getChartData()
        );

        return view('boss.dashboard', $metrics);
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
