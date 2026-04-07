<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Ticket;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Métricas de Inventario
        $totalAssets = Asset::count();
        $assetsByType = Asset::select('type', \DB::raw('count(*) as count'))->groupBy('type')->get();
        $assetsByStatus = Asset::select('status', \DB::raw('count(*) as count'))->groupBy('status')->get();

        // Métricas de Tickets
        $totalTickets = Ticket::count();
        $ticketsByStatus = Ticket::select('status', \DB::raw('count(*) as count'))->groupBy('status')->get();
        $resolvedLast30Days = Ticket::where('status', 'Resolved')->where('updated_at', '>=', now()->subDays(30))->count();

        return view('admin.reports.index', compact(
            'totalAssets', 'assetsByType', 'assetsByStatus',
            'totalTickets', 'ticketsByStatus', 'resolvedLast30Days'
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
