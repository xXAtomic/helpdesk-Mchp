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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // 1. Estadísticas para el Dashboard ✨
        $ticketsCount = Ticket::where('user_id', $user->id)
            ->whereHas('status', function($q) {
                $q->where('is_closed', false);
            })->count();

        $resolvedTodayCount = Ticket::where('user_id', $user->id)
            ->whereHas('status', function($q) {
                $q->where('key', 'resolved'); // O el nombre de tu estado cerrado
            })
            ->where('updated_at', '>=', now()->startOfDay())
            ->count();
        
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

        // 3. Equipos asignados al usuario
        $assignedAssets = $user->assets()->get();

        // 4. Compliance Status ⚖️
        $signedIds = \App\Models\DocumentSignature::where('user_id', $user->id)
            ->where('is_accepted', true)
            ->pluck('legal_document_id')
            ->toArray();

        $pendingComplianceCount = \App\Models\LegalDocument::where('is_active', true)
            ->whereNotIn('id', $signedIds)
            ->where(function($q) use ($user) {
                if ($user->entity === 'BOTH') {
                    $q->whereIn('entity', ['IASD', 'FESDG', 'BOTH', null]);
                } else {
                    $q->whereIn('entity', [$user->entity, 'BOTH', null]);
                }
            })
            ->count();

        return view('user.dashboard', compact(
            'ticketsCount',
            'resolvedTodayCount',
            'closedTickets',
            'latestTickets',
            'assignedAssets',
            'pendingComplianceCount'
        ));
    }
}
