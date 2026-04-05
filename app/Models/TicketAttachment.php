<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
<<<<<<< HEAD
        'ticket_response_id',
=======
        'ticket_reply_id',
>>>>>>> origin/servidor-maraton-ayer
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

<<<<<<< HEAD
    public function ticketResponse()
    {
        return $this->belongsTo(TicketResponse::class);
=======
    public function ticketReply()
    {
        return $this->belongsTo(TicketReply::class);
>>>>>>> origin/servidor-maraton-ayer
    }
}
