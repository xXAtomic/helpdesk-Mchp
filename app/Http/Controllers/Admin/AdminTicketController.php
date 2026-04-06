<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketResponse;

class AdminTicketController extends Controller
{
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
    // 1. Validamos los datos
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'attachment' => 'nullable|image|max:5120',
    ]);

    // 2. Procesamos la imagen si existe
    $path = null;
    if ($request->hasFile('attachment')) {
        $path = $request->file('attachment')->store('attachments', 'public');
    }

    // 3. Creamos el ticket
    \App\Models\Ticket::create([
        'requester_name'  => $request->name,
        'requester_email' => $request->email,
        'department_name' => $request->department,
        'title'           => $request->title,
        'description'     => $request->description,
        'attachment_path' => $path,
        'user_id'         => auth()->id(),
        'ticket_number'   => 'TCK-' . strtoupper(uniqid())
    ]);

    return redirect()->route('admin.tickets.index')->with('success', 'Ticket creado.');
}



    public function reply(Request $request, $id)
    {
        $request->validate(['body' => 'required']);

        TicketResponse::create([
            'ticket_id' => $id,
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        return back()->with('success', 'Respuesta enviada correctamente.');
    }

    public function create()
    {
        return view('admin.tickets.create');
    }
}
