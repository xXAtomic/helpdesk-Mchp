<?php

namespace App\Services;

use App\Models\Supply;
use App\Models\SupplyLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Servicio centralizado para la gestión de movimientos de stock.
 * Garantiza la integridad de los datos y la generación automática de logs de auditoría.
 */
class InventoryService
{
    /**
     * Registra un nuevo tipo de insumo y genera el primer log de ingreso si tiene stock.
     */
    public function register(array $data): Supply
    {
        return DB::transaction(function() use ($data) {
            $supply = Supply::create($data);

            if ($supply->stock > 0) {
                $this->createLog($supply, [
                    'quantity' => $supply->stock,
                    'action' => 'RESTOCK',
                    'notes' => 'Ingreso inicial de mercancía al sistema.'
                ]);
            }

            return $supply;
        });
    }

    /**
     * Procesa la salida de material (Consumo o Préstamo).
     */
    public function consume(Supply $supply, array $data): void
    {
        DB::transaction(function() use ($supply, $data) {
            $supply->decrement('stock', $data['quantity']);

            $this->createLog($supply, [
                'user_id' => $data['user_id'],
                'quantity' => $data['quantity'],
                'action' => $data['action'],
                'equipment_tag' => $data['equipment_tag'] ?? null,
                'status' => $data['action'] === 'LOAN' ? 'PENDING_RETURN' : 'COMPLETED',
                'notes' => $data['notes'] ?? null
            ]);
        });
    }

    /**
     * Incrementa el stock por reabastecimiento.
     */
    public function restock(Supply $supply, int $quantity, ?string $notes = null): void
    {
        DB::transaction(function() use ($supply, $quantity, $notes) {
            $supply->increment('stock', $quantity);

            $this->createLog($supply, [
                'quantity' => $quantity,
                'action' => 'RESTOCK',
                'notes' => $notes
            ]);
        });
    }

    /**
     * Procesa la devolución formal de un material prestado.
     */
    public function handleReturn(SupplyLog $log): void
    {
        DB::transaction(function() use ($log) {
            $log->supply->increment('stock', $log->quantity);
            $log->update(['status' => 'RETURNED']);

            $this->createLog($log->supply, [
                'user_id' => $log->user_id,
                'quantity' => $log->quantity,
                'action' => 'RETURN',
                'status' => 'COMPLETED',
                'notes' => 'Devolución formal de material del préstamo #' . $log->id
            ]);
        });
    }

    /**
     * Helper interno para estandarizar la creación de logs.
     */
    private function createLog(Supply $supply, array $params): void
    {
        $supply->logs()->create(array_merge([
            'admin_id' => Auth::id(),
            'created_at' => now(),
        ], $params));
    }
}
