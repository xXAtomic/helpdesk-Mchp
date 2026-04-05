<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Equipment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
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
    }
}
