<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Estadísticas simples para el usuario
        $totalTickets = Ticket::where('user_id', $user->id)->count();
        $openTickets = Ticket::where('user_id', $user->id)
            ->whereHas('status', function($q) {
                $q->where('is_closed', false);
            })->count();
        $closedTickets = Ticket::where('user_id', $user->id)
            ->whereHas('status', function($q) {
                $q->where('is_closed', true);
            })->count();
        
        // 2. Últimos tickets creados por el usuario
        $latestTickets = Ticket::where('user_id', $user->id)
            ->with(['status', 'priority', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'latestTickets'
        ));
    }
}
