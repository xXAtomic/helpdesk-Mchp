<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use App\Models\TicketCategory;
use Illuminate\Support\Str;

class FetchEmailTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gravity:fetch-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa el buzón de soporte y convierte correos nuevos en tickets.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Conectando al servidor de correo...");

        try {
            $client = Client::account('default');
            $client->connect();
        } catch (\Exception $e) {
            $this->error("Error de conexión: " . $e->getMessage());
            return 1;
        }

        $this->info("Conexión exitosa. Revisando INBOX...");

        // Seleccionamos la carpeta de entrada
        $folder = $client->getFolder('INBOX');
        
        // Buscamos solo los mensajes no leídos ("UNSEEN")
        $messages = $folder->query()->unseen()->get();

        if ($messages->count() === 0) {
            $this->info("No hay correos nuevos.");
            return 0;
        }

        $this->info("Se encontraron {$messages->count()} correos nuevos. Procesando...");

        // Estados y prioridades por defecto
        $statusOpen = TicketStatus::where('slug', 'abierto')->first();
        $priorityLow = TicketPriority::where('slug', 'baja')->first();
        $categoryIncidence = TicketCategory::where('slug', 'incidencia')->first();

        foreach ($messages as $message) {
            $subject = $message->getSubject();
            $from = $message->getFrom()[0]->mail;
            $body = $message->getTextBody() ?: $message->getHTMLBody(true);
            
            $this->line("Procesando: [{$from}] {$subject}");

            // Buscamos si el usuario existe en el sistema
            $user = User::where('email', $from)->first();

            // Si el sistema es SaaS, podríamos crear un usuario temporal o rechazarlo
            // Por ahora, si no existe, usaremos el administrador como creador 
            // pero guardaremos los datos del solicitante original.
            
            $ticket = Ticket::create([
                'title' => $subject,
                'description' => $body,
                'user_id' => $user ? $user->id : 1, // Fallback al Admin si no existe
                'requester_email' => $from,
                'requester_name' => $message->getFrom()[0]->personal ?: $from,
                'status_id' => $statusOpen->id,
                'priority_id' => $priorityLow->id,
                'category_id' => $categoryIncidence->id,
            ]);

            $this->info("✓ Ticket creado: {$ticket->ticket_number}");

            // Marcamos el correo como leído para no procesarlo de nuevo
            $message->setFlag('Seen');
            
            // Opcional: Podrías moverlo a una carpeta "PROCESADOS"
            // $message->move('INBOX/Processed');
        }

        $this->info("Proceso finalizado.");
        return 0;
    }
}
