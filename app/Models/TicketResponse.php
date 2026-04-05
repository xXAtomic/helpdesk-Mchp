<?php

// app/Models/TicketResponse.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TicketResponse extends Model
{
<<<<<<< HEAD
    protected $table = 'ticket_responses';
=======
    protected $table = 'ticket_resplies';
>>>>>>> origin/servidor-maraton-ayer
    protected $fillable = ['ticket_id', 'user_id', 'body', 'is_internal'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
<<<<<<< HEAD

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
=======
>>>>>>> origin/servidor-maraton-ayer
}
