<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Asset;

class DashboardController extends Controller
{
    public function index()
    {
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
    }
}
