<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TicketPriority;
use App\Models\TicketCategory;
use App\Models\Department;
use App\Models\Ticket;
use App\Services\TicketService;
use App\Services\SystemMetricsService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketService;
    protected $metricsService;

    public function __construct(TicketService $ticketService, SystemMetricsService $metricsService)
    {
        $this->ticketService = $ticketService;
        $this->metricsService = $metricsService;
    }

    public function index()
    {
        $user = request()->user();
        $tickets = $user->requestedTickets()->with(['status', 'category'])->latest()->paginate(10);
        
        // Delegamos las estadísticas al servicio táctico
        $stats = $this->metricsService->getTicketSummary($user);

        return view('user.tickets.index', compact('tickets', 'stats'));
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

        $attachments = $request->file('attachments') ?? [];

        try {
            $ticket = $this->ticketService->createTicket($validated, $request->user()->id, $attachments);
            return redirect()->route('user.tickets.show', $ticket)->with('success', 'SOLICITUD REGISTRADA ✅: Su incidente ha sido ingresado al sistema correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ ERROR AL REGISTRAR: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Ticket $ticket)
    {
        // Autorización local
        if ($ticket->user_id !== request()->user()->id) {
            abort(403);
        }

        $ticket->load(['publicReplies.user', 'status', 'priority', 'category', 'attachments']);
        return view('user.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== request()->user()->id) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB Máx por archivo
        ]);
        
        try {
            $this->ticketService->replyToTicket(
                $ticket, 
                $request->body, 
                $request->user()->id, 
                false, 
                $request->file('attachments') ?? []
            );

            return redirect()->route('user.tickets.show', $ticket)->with('success', '✅ TU MENSAJE SE HA ENVIADO Y REGISTRADO.');
        } catch (\Exception $e) {
            return redirect()->route('user.tickets.show', $ticket)->with('error', '❌ ERROR AL ENVIAR: ' . $e->getMessage());
        }
    }
    public function rate(Request $request, Ticket $ticket)
    {
        // Validación de pertenencia rápida
        if ($ticket->user_id !== $request->user()->id) abort(403);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            $this->ticketService->rateTicket($ticket, $validated, $request->user()->id);
            return redirect()->route('user.tickets.show', $ticket)->with('success', '✅ ¡GRACIAS! TU VALORACIÓN HA SIDO REGISTRADA.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ ERROR: ' . $e->getMessage());
        }
    }
}
