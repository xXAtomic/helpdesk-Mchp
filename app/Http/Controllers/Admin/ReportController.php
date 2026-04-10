<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\SystemMetricsService;

class ReportController extends Controller
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

        return view('admin.reports.index', $metrics);
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
