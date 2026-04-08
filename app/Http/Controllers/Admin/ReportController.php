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
        // Métricas de Inventario
        $totalAssets = Asset::count();
        $assetsByType = Asset::select('type', DB::raw('count(*) as count'))->groupBy('type')->get();
        $assetsByStatus = Asset::select('status', DB::raw('count(*) as count'))->groupBy('status')->get();

        // Métricas de Tickets
        $totalTickets = Ticket::count();
        $ticketsByStatus = Ticket::join('ticket_statuses', 'tickets.status_id', '=', 'ticket_statuses.id')
            ->select('ticket_statuses.name as status', DB::raw('count(*) as count'))
            ->groupBy('ticket_statuses.name')
            ->get();

        $resolvedLast30Days = Ticket::whereHas('status', function($q) {
            $q->where('is_closed', true);
        })->where('updated_at', '>=', now()->subDays(30))->count();

        // Métricas de Mantenimiento ✨
        $maintenanceOverdue = Asset::where('next_maintenance_at', '<', now())->count();
        $maintenanceComingSoon = Asset::whereBetween('next_maintenance_at', [now(), now()->addDays(30)])->count();
        $totalMaintenanceThisMonth = \App\Models\AssetLog::where('action', 'MAINTENANCE')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Métricas de Satisfacción (CSAT) ✨
        $avgRating = TicketRating::avg('rating') ?? 0;
        $ratingsCount = TicketRating::count();
        $ratingsDistribution = TicketRating::select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        return view('admin.reports.index', compact(
            'totalAssets', 'assetsByType', 'assetsByStatus',
            'totalTickets', 'ticketsByStatus', 'resolvedLast30Days',
            'maintenanceOverdue', 'maintenanceComingSoon', 'totalMaintenanceThisMonth',
            'avgRating', 'ratingsCount', 'ratingsDistribution'
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
