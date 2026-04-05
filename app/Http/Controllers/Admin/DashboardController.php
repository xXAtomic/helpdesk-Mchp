<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
<<<<<<< HEAD
use App\Models\User;
use App\Models\Asset;
=======
use App\Models\Equipment;
use App\Models\User;
>>>>>>> origin/servidor-maraton-ayer

class DashboardController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $openTickets = Ticket::query()->whereHas('status', function($q){ $q->where('is_closed', false); })->count();
        $totalUsers = User::query()->count();
        $totalAssets = Asset::query()->count();

        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Si es técnico, solo vemos los asignados a él
        if ($user && $user->isTechnician()) {
            $myTickets = Ticket::query()->where('technician_id', $user->id)
                                ->whereHas('status', function($q) { $q->where('is_closed', false); })
                                ->count();
        } else {
            $myTickets = $openTickets; // Admin/Supervisor ven todo
        }

        return view('admin.dashboard', compact('openTickets', 'totalUsers', 'totalAssets', 'myTickets'));
=======
        // Estadísticas reales para tus tarjetas
        $stats = [
            'total_tickets'   => Ticket::count(),
            'open_tickets'    => Ticket::whereNull('closed_at')->count(), // Corregido ✅
            'total_equipment' => Equipment::count(),
            'total_users'     => User::count(),
        ];

        // Últimos 5 tickets para la tabla de actividad
        $recentTickets = Ticket::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentTickets'));
>>>>>>> origin/servidor-maraton-ayer
    }
}
