<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
<<<<<<< HEAD
use App\Models\TicketStatus;
=======
use App\Models\Status;
>>>>>>> origin/servidor-maraton-ayer
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
<<<<<<< HEAD
        $statuses = TicketStatus::all();
=======
        $statuses = Status::all();
>>>>>>> origin/servidor-maraton-ayer
        
        return view('admin.tickets.show', compact('ticket', 'technicians', 'statuses'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'body' => 'required|string',
<<<<<<< HEAD
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
=======
            'is_internal' => 'boolean'
        ]);
        
        $this->ticketService->replyToTicket($ticket, $request->body, $request->user()->id, $request->is_internal ?? false);
>>>>>>> origin/servidor-maraton-ayer

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
<<<<<<< HEAD
        $request->validate(['status_id' => 'required|exists:ticket_statuses,id']);
=======
        $request->validate(['status_id' => 'required|exists:statuses,id']);
>>>>>>> origin/servidor-maraton-ayer
        $this->ticketService->updateStatus($ticket, $request->status_id, $request->user()->id);
        return back()->with('success', 'Estado actualizado.');
    }
}
