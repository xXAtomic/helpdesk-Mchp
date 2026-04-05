<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment'; // Forzamos el nombre de la tabla
    
    protected $fillable = [
        'name', 'brand', 'model', 'serial_number', 
        'inventory_code', 'type', 'status', 'location', 'notes'
    ];
}
