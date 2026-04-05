<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'ticket_response_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function ticketResponse()
    {
        return $this->belongsTo(TicketResponse::class);
    }
}
