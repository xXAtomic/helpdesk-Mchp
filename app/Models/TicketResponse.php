<?php

// app/Models/TicketResponse.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TicketResponse extends Model
{
    protected $table = 'ticket_resplies';
    protected $fillable = ['ticket_id', 'user_id', 'body', 'is_internal'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
