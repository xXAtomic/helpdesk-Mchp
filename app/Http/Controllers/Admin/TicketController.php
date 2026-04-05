<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketStatus;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $tickets = Ticket::with(['user', 'technician', 'status', 'priority', 'category'])->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('replies.user', 'status', 'priority', 'category', 'user', 'technician');
        $technicians = User::whereHas('role', function($q) {
            $q->whereIn('slug', ['admin', 'technician', 'supervisor']);
        })->get();
        $statuses = TicketStatus::all();
        
        return view('admin.tickets.show', compact('ticket', 'technicians', 'statuses'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'body' => 'required|string',
            'is_internal' => 'boolean',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);
        
        $this->ticketService->replyToTicket(
            $ticket, 
            $request->body, 
            $request->user()->id, 
            $request->is_internal ?? false,
            $request->file('attachments') ?? []
        );

        return redirect()->route('admin.tickets.show', $ticket)->with('success', 'Respuesta agregada.');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate(['technician_id' => 'required|exists:users,id']);
        $this->ticketService->assignTechnician($ticket, $request->technician_id, $request->user()->id);
        return back()->with('success', 'Técnico asignado.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate(['status_id' => 'required|exists:ticket_statuses,id']);
        $this->ticketService->updateStatus($ticket, $request->status_id, $request->user()->id);
        return back()->with('success', 'Estado actualizado.');
    }
}
