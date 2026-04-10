<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Ticket;
use App\Models\TicketRating;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Total de tickets
        $ticketsCount = Ticket::count();

        // 2. Número de tickets cerrados TOTAL
        $resolvedCount = Ticket::whereHas('status', function($q) {
            $q->where('is_closed', true);
        })->count();

        // 2b. Tickets resueltos este mes
        $monthlyResolvedCount = Ticket::whereHas('status', function($q) {
                $q->where('is_closed', true);
            })
            ->whereBetween('resolved_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        // 3. Número de equipos registrados
        $equipmentCount = Asset::count();

        // 4. Tiempo de respuesta promedio
        $ticketsWithResolution = Ticket::whereNotNull('resolved_at')->get();
        if ($ticketsWithResolution->count() > 0) {
            $totalHours = $ticketsWithResolution->sum(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->resolved_at);
            });
            $avgResponseTime = round($totalHours / $ticketsWithResolution->count(), 1) . ' h';
        } else {
            $avgResponseTime = '0 h';
        }

        // 5. Calificación promedio CSAT
        $avgRating = \App\Models\TicketRating::avg('rating') ?? 0;
        $avgRating = round($avgRating, 1);

        // 6. Datos para Gráfico de Dona
        $statusStats = [
            'Pendientes' => Ticket::whereHas('status', fn($q) => $q->where('name', 'Abierto'))->count(),
            'En Progreso' => Ticket::whereHas('status', fn($q) => $q->where('name', 'En Progreso'))->count(),
            'Resueltos' => Ticket::whereHas('status', fn($q) => $q->where('is_closed', true))->count(),
        ];

        // 7. Datos para Gráfico de Tendencia (7 días)
        $days = [];
        $ticketsCreated = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->translatedFormat('D');
            $ticketsCreated[] = Ticket::whereDate('created_at', $date->toDateString())->count();
        }

        // 8. Datos Financieros ✨
        $totalHardwareInvestment = Asset::sum('purchase_cost') ?? 0;

        $totalMonthlyPurchases = \App\Models\SupplyLog::where('action', 'RESTOCK')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('supply')
            ->get()
            ->sum(function($log) {
                return $log->quantity * ($log->supply->unit_cost ?? 0);
            });

        $totalMonthlyConsumptions = \App\Models\SupplyLog::where('action', 'CONSUMPTION')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('supply')
            ->get()
            ->sum(function($log) {
                return $log->quantity * ($log->supply->unit_cost ?? 0);
            });

        // 9. Auditoría Reciente
        $recentTransactions = \App\Models\SupplyLog::latest()
            ->with(['supply', 'user', 'admin'])
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'ticketsCount', 'resolvedCount', 'monthlyResolvedCount',
            'equipmentCount', 'avgResponseTime', 'avgRating',
            'statusStats', 'days', 'ticketsCreated',
            'totalHardwareInvestment', 'totalMonthlyPurchases',
            'totalMonthlyConsumptions', 'recentTransactions'
        ));
    }

    public function exportCsv()
    {
        $assets = Asset::with('user')->get();
        
        $filename = "inventario_mchp_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // UTF-8 BOM para Excel
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Encabezados
        fputcsv($handle, ['ID', 'Etiqueta', 'Tipo', 'Marca', 'Modelo', 'Serie', 'Estado', 'Ubicacion', 'Usuario']);
        
        foreach ($assets as $asset) {
            fputcsv($handle, [
                $asset->id,
                $asset->asset_tag,
                $asset->type,
                $asset->brand,
                $asset->model,
                $asset->serial_number,
                $asset->status,
                $asset->location,
                $asset->user->name ?? 'N/A'
            ]);
        }
        
        fclose($handle);
        exit;
    }

    public function exportInventoryPdf()
    {
        // En lugar de una librería compleja, enviamos a una vista optimizada de impresión
        $items = Asset::all();
        return view('admin.reports.inventory-print', compact('items'));
    }
}
