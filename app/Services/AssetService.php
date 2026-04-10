<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssetService
{
    /**
     * Obtiene los activos filtrados por búsqueda, tipo y estado.
     */
    public function getFilteredAssets(array $filters)
    {
        $query = Asset::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('asset_tag', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->with('user')->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Registra un nuevo activo con auditoría automática.
     */
    public function createAsset(array $data)
    {
        return DB::transaction(function() use ($data) {
            if (!isset($data['status'])) $data['status'] = 'Operativo';
            
            $asset = Asset::create($data);

            $this->logAction($asset, 'CREATE', null, $asset->toArray(), 'Activo registrado por primera vez.');

            return $asset;
        });
    }

    /**
     * Actualiza un activo y registra los cambios.
     */
    public function updateAsset(Asset $asset, array $data)
    {
        return DB::transaction(function() use ($asset, $data) {
            $oldData = $asset->toArray();
            $asset->update($data);

            $this->logAction($asset, 'UPDATE', $oldData, $asset->toArray(), 'Actualización de datos del equipo.');

            return $asset;
        });
    }

    /**
     * Registra una intervención de mantenimiento.
     */
    public function recordMaintenance(Asset $asset, array $data)
    {
        return DB::transaction(function() use ($asset, $data) {
            $oldData = $asset->toArray();

            $asset->update([
                'last_maintenance_at' => now(),
                'next_maintenance_at' => $data['next_maintenance_at'],
                'status'              => $data['status'] ?? $asset->status,
            ]);

            $this->logAction($asset, 'MAINTENANCE', $oldData, $asset->toArray(), "MANTENIMIENTO REALIZADO: " . $data['details']);

            return $asset;
        });
    }

    /**
     * Helper centralizado para auditoría de activos.
     */
    private function logAction(Asset $asset, string $action, ?array $oldData, array $newData, string $details)
    {
        AssetLog::create([
            'asset_id' => $asset->id,
            'user_id'  => Auth::id(),
            'action'   => $action,
            'old_data' => $oldData,
            'new_data' => $newData,
            'details'  => $details
        ]);
    }
}
