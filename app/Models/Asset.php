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
        'next_maintenance_at'
    ];

    protected $casts = [
        'last_maintenance_at' => 'date',
        'next_maintenance_at' => 'date',
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
}
