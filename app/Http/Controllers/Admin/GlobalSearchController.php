<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Asset;
use App\Models\User;

class GlobalSearchController extends Controller
{
    /**
     * Motor de Búsqueda Neural para el Administrador
     * Busca en Tickets, Activos e Inventario de forma consolidada.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        // 1. Buscar en Tickets
        $tickets = Ticket::where('title', 'like', "%$query%")
            ->orWhere('ticket_number', 'like', "%$query%")
            ->take(5)
            ->get()
            ->map(fn($t) => [
                'type' => 'Ticket',
                'title' => $t->title,
                'subtitle' => "ID: " . $t->ticket_number,
                'url' => route('admin.tickets.show', $t->id),
                'icon' => 'fas fa-ticket-alt',
                'color' => 'bg-indigo-500'
            ]);

        // 2. Buscar en Activos (Inventario)
        $assets = Asset::where('asset_tag', 'like', "%$query%")
            ->orWhere('serial_number', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->orWhere('brand', 'like', "%$query%")
            ->orWhereHas('user', function($qu) use ($query) {
                $qu->where('name', 'like', "%$query%");
            })
            ->take(5)
            ->get()
            ->map(fn($a) => [
                'type' => 'Activo',
                'title' => $a->asset_tag,
                'subtitle' => $a->brand . ' ' . $a->model . ($a->user ? ' ('.$a->user->name.')' : ''),
                'url' => route('admin.inventory.show', $a->id),
                'icon' => 'fas fa-laptop',
                'color' => 'bg-emerald-500'
            ]);

        // 3. Buscar en Usuarios
        $users = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'type' => 'Usuario',
                'title' => $u->name,
                'subtitle' => $u->email,
                'url' => route('admin.users.edit', $u->id),
                'icon' => 'fas fa-user-tag',
                'color' => 'bg-amber-500'
            ]);

        return response()->json($tickets->concat($assets)->concat($users));
    }
}
