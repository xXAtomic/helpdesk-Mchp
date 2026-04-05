<?php

// app/Models/TicketCategory.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TicketCategory extends Model
{
    protected $fillable = ['name', 'slug', 'color'];
}
