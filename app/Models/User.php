<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // --- RELACIONES ---

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function requestedTickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function inventories()
    {
        return $this->hasMany(Asset::class, 'user_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'user_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'technician_id');
    }

    // --- AYUDANTES DE AUTENTICACIÓN (PROFESIONAL) ---

    public function hasRole($roles)
    {
        if (!$this->role)
            return false;
        if (is_array($roles)) {
            return in_array($this->role->slug, $roles);
        }
        return $this->role->slug === $roles;
    }

    public function isAdmin()
    {
        return $this->role && $this->role->slug === 'admin';
    }

    public function isBoss()
    {
        return $this->role && $this->role->slug === 'supervisor';
    }

    public function isTechnician()
    {
        return $this->role && $this->role->slug === 'technician';
    }

    public function isUser()
    {
        return $this->role && $this->role->slug === 'user';
    }
}
