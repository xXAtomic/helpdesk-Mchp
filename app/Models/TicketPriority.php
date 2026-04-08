<?php

// app/Models/TicketPriority.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    protected $fillable = ['name', 'slug', 'color', 'level', 'sla_hours'];

    protected $casts = [
        'sla_hours' => 'integer',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }
}
