<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'user_id',
        'technician_id',
        'department_id',
        'category_id',
        'priority_id',
        'status_id',
        'asset_id',
        'due_date',
        'resolved_at',
        'closed_at',
        'requester_name',
        'requester_email',
        'department_name',
        'attachment_path',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    // --- RELACIONES ---

    public function user() 
    { 
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function technician() 
    { 
        return $this->belongsTo(User::class, 'technician_id'); 
    }

    public function department() 
    { 
        return $this->belongsTo(Department::class); 
    }

    public function category() 
    { 
        return $this->belongsTo(TicketCategory::class); 
    }

    public function priority() 
    { 
        return $this->belongsTo(TicketPriority::class); 
    }

    public function status() 
    { 
        return $this->belongsTo(TicketStatus::class); 
    }

    public function asset() 
    { 
        return $this->belongsTo(Asset::class); 
    }

    public function replies() 
    { 
        return $this->hasMany(TicketResponse::class); 
    }

    public function attachments() 
    { 
        return $this->hasMany(TicketAttachment::class); 
    }

    // --- GENERADOR DE NÚMERO DE TICKET AUTOMÁTICO ---
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            if (!$ticket->ticket_number) {
                // TCK-YYYYMMDD-XXXXX
                $ticket->ticket_number = 'TCK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            }
        });
    }
}
