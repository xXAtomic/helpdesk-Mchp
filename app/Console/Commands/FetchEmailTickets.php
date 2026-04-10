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
        $priorityLow = TicketPriority::where('slug', 'baja')->first();
        $categoryIncidence = TicketCategory::where('slug', 'incidencia')->first();
        $userRole = \App\Models\Role::where('slug', 'user')->first();

        foreach ($messages as $message) {
            $subject = $message->getSubject();
            $from = $message->getFrom()[0]->mail;
            $body = $message->getTextBody() ?: $message->getHTMLBody(true);

            // LOGICA DE EXTRACCIÓN DE REMITENTE ORIGINAL (Para Power Automate)
            // Si el asunto viene con el tag FROM:[correo] | ...
            if (str_contains($subject, 'FROM:')) {
                preg_match('/FROM:([\w\.-]+@[\w\.-]+\.\w+)/', $subject, $matches);
                if (isset($matches[1])) {
                    $originalFrom = $matches[1];
                    $this->info("📧 Remitente original detectado: {$originalFrom}");
                    $from = $originalFrom;
                    // Limpiamos el asunto para que no quede feo
                    $subject = trim(explode('|', $subject, 2)[1] ?? $subject);
                }
            }
            
            $this->line("Procesando: [{$from}] {$subject}");

            // Buscamos si el usuario existe en el sistema
            $user = User::where('email', $from)->first();

            // Si no existe, lo creamos automáticamente para que el sistema pueda notificarle
            if (!$user) {
                $user = User::create([
                    'name' => $message->getFrom()[0]->personal ?: explode('@', $from)[0],
                    'email' => $from,
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                    'role_id' => $userRole->id,
                    'is_active' => true,
                ]);
                $this->info("ℹ Usuario creado automáticamente para: {$from}");
            }

            // Usamos el TicketService para heredar toda la lógica de notificaciones
            $ticketData = [
                'title' => $subject,
                'description' => $body,
                'category_id' => $categoryIncidence->id,
                'priority_id' => $priorityLow->id,
            ];

            $ticket = app(\App\Services\TicketService::class)->createTicket($ticketData, $user->id);

            $this->info("✓ Ticket creado: {$ticket->ticket_number} (Notificación enviada a {$from})");

            // Marcamos el correo como leído para no procesarlo de nuevo
            $message->setFlag('Seen');
        }

        $this->info("Proceso finalizado.");
        return 0;
    }
}
