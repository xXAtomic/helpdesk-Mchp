<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketResponse;

use App\Services\TicketService;

class AdminTicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        // Estadísticas para las tarjetas superiores
        $stats = [
            'open'     => Ticket::whereNull('closed_at')->count(),
            'closed'   => Ticket::whereNotNull('closed_at')->count(),
            'avg_time' => '2.5h', 
            'total'    => Ticket::count(),
        ];

        // Listado de tickets
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.tickets.index', compact('tickets', 'stats'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['user', 'replies.user'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:ticket_categories,id',
            'priority_id' => 'nullable|exists:ticket_priorities,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $attachments = $request->file('attachments') ?? [];
        
        $ticket = $this->ticketService->createTicket($validated, auth()->id(), $attachments);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket creado correctamente mediante el centro de administración.');
    }




    public function reply(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $request->validate([
            'body' => 'required',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $this->ticketService->replyToTicket(
            $ticket, 
            $request->body, 
            auth()->id(), 
            true, // Admins usually reply as internal/staff
            $request->file('attachments') ?? []
        );

        return back()->with('success', 'Respuesta técnica registrada correctamente.');
    }

    public function assign(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $request->validate(['technician_id' => 'nullable|exists:users,id']);
        
        $this->ticketService->assignTechnician($ticket, $request->technician_id, auth()->id());
        
        return back()->with('success', 'Técnico asignado exitosamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $request->validate(['status_id' => 'required|exists:ticket_statuses,id']);
        
        $this->ticketService->updateStatus($ticket, $request->status_id, auth()->id());
        
        return back()->with('success', 'Estado del ticket actualizado.');
    }


    public function create()
    {
        return view('admin.tickets.create');
    }
}
