<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TicketPriority;
use App\Models\TicketCategory;
use App\Models\Department;
use App\Models\Ticket;
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
        $tickets = request()->user()->requestedTickets()->latest()->paginate(10);
        return view('user.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = TicketCategory::all();
        $priorities = TicketPriority::all();
        $departments = Department::all();
        
        return view('user.tickets.create', compact('categories', 'priorities', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:ticket_categories,id',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $ticket = $this->ticketService->createTicket(
            $validated, 
            $request->user()->id,
            $request->file('attachments') ?? []
        );

        return redirect()->route('user.tickets.show', $ticket)->with('success', 'Ticket creado exitosamente.');
    }

    public function show(Ticket $ticket)
    {
        // Autorización local
        if ($ticket->user_id !== request()->user()->id) {
            abort(403);
        }

        $ticket->load('replies.user', 'status', 'priority', 'category');
        return view('user.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== request()->user()->id) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240',
        ]);
        
        $this->ticketService->replyToTicket(
            $ticket, 
            $request->body, 
            $request->user()->id, 
            false,
            $request->file('attachments') ?? []
        );

        return redirect()->route('user.tickets.show', $ticket)->with('success', 'Respuesta agregada.');
    }
}
