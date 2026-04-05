<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id', 'details', 'ip_address'
    ];

<<<<<<< HEAD
    protected $casts = [
        'details' => 'array',
    ];

=======
>>>>>>> origin/servidor-maraton-ayer
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
