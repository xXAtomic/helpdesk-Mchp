<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'type',
        'brand',
        'model',
        'serial_number',
        'status',
        'location',
        'user_id',
        'last_maintenance_at',
        'next_maintenance_at',
        'purchase_cost',
        'purchased_at',
        'entity'
    ];

    protected $casts = [
        'last_maintenance_at' => 'date',
        'next_maintenance_at' => 'date',
        'purchased_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function logs()
    {
        return $this->hasMany(AssetLog::class)->orderBy('created_at', 'desc');
    }

    /** --- INTELIGENCIA DE MANTENIMIENTO PREVENTIVO --- **/

    /**
     * Determina el estado de salud basado en la fecha del próximo mantenimiento.
     */
    public function getHealthStatusAttribute()
    {
        if (!$this->next_maintenance_at) return 'S/Mantenimiento';

        $now = now();
        $next = $this->next_maintenance_at;

        if ($next->isPast()) {
            return 'Mantenimiento Vencido';
        }

        if ($next->diffInDays($now) <= 30) {
            return 'Próximo a Vencer';
        }

        return 'Salud Óptima';
    }

    /**
     * Devuelve la clase de color de Tailwind según la salud.
     */
    public function getHealthColorAttribute()
    {
        $status = $this->getHealthStatusAttribute();

        return match ($status) {
            'Mantenimiento Vencido' => 'rose',
            'Próximo a Vencer'      => 'amber',
            'Salud Óptima'          => 'emerald',
            default                 => 'slate',
        };
    }
}

