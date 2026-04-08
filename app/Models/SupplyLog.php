<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_id',
        'user_id',
        'admin_id',
        'equipment_tag',
        'quantity',
        'action',
        'status',
        'notes'
    ];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
