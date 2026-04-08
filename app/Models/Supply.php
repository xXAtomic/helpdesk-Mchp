<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'type',
        'stock',
        'min_stock',
        'location',
        'unit_cost'
    ];

    public function logs()
    {
        return $this->hasMany(SupplyLog::class);
    }

    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }
}
