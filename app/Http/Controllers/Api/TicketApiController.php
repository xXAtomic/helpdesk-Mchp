<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketApiController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        // En una API real es buena práctica utilizar Resources/Colecciones o DTOs.
        $tickets = Ticket::query()->with(['user:id,name', 'technician:id,name', 'status', 'priority'])->latest()->paginate(20);
        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'user_id' => 'required|exists:users,id', // Vía API puedes crearle el ticket a otro.
        ]);

        $ticket = $this->ticketService->createTicket($validated, $validated['user_id']);

        return response()->json([
            'message' => 'Ticket generado correctamente.',
            'ticket' => $ticket
        ], 201);
    }

    public function show($id)
    {
        $ticket = Ticket::query()->with('replies.user:id,name', 'status', 'priority')->findOrFail($id);
        return response()->json($ticket);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::query()->findOrFail($id);
        
        // Actualizar datos básicos (No se aconseja alterar descripciones, pero sí estados o tecnicos para no vulnerar logs).
        if ($request->has('status_id')) {
            $this->ticketService->updateStatus($ticket, $request->status_id, request()->user()->id);
        }

        if ($request->has('technician_id')) {
            $this->ticketService->assignTechnician($ticket, $request->technician_id, request()->user()->id);
        }

        return response()->json([
            'message' => 'Ticket actualizado',
            'ticket' => $ticket->fresh(['status', 'technician'])
        ]);
    }
}
