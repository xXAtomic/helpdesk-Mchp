<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        'due_at',
        'resolved_at',
        'closed_at',
        'sla_breached',
        'requester_name',
        'requester_email',
        'department_name',
        'attachment_path',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'due_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'sla_breached' => 'boolean',
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

    public function publicReplies() 
    { 
        return $this->hasMany(TicketResponse::class)->where('is_internal', false); 
    }

    public function attachments() 
    { 
        return $this->hasMany(TicketAttachment::class); 
    }

    public function rating()
    {
        return $this->hasOne(TicketRating::class);
    }

    // --- LÓGICA DE NEGOCIO ---

    /**
     * Calcula si el ticket ha incumplido el SLA.
     */
    public function checkSlaStatus()
    {
        if ($this->resolved_at) {
            return $this->resolved_at->gt($this->due_at);
        }
        return now()->gt($this->due_at);
    }

    /**
     * Obtiene el tiempo restante en formato legible.
     */
    public function getSlaRemainingAttribute()
    {
        if (!$this->due_at || $this->resolved_at) return null;
        
        if (now()->gt($this->due_at)) {
            return 'VENCIDO';
        }
        
        return now()->diffForHumans($this->due_at, true);
    }

    // --- GENERADOR DE NÚMERO DE TICKET AUTOMÁTICO Y SLA ---
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ticket) {
            // Número de ticket
            if (!$ticket->ticket_number) {
                $ticket->ticket_number = 'TCK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            }
            
            // Cálculo de SLA (Due At)
            if ($ticket->priority_id && !$ticket->due_at) {
                $priority = TicketPriority::find($ticket->priority_id);
                if ($priority && $priority->sla_hours) {
                    $ticket->due_at = Carbon::now()->addHours($priority->sla_hours);
                }
            }
        });
    }
}
