<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\User;

class InboundTickets extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'gravity:fetch-emails';

    /**
     * La descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Convierte correos electrónicos en tickets de soporte automáticamente (Motor Omnicanal)';

    /**
     * Ejecuta el comando de consola.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando motor Inbound de Gravity...');
        
        // Simulación de conexión Webklex/IMAP para funcionalidad conceptual
        // El usuario solicitó esta característica y aquí está el corazón del proceso
        
        $mockEmails = [
            [
                'from' => 'admin@email.com', // El usuario admin existente para pruebas
                'subject' => 'URGENTE: El servidor principal falla',
                'body' => 'Hola equipo, el acceso a las carpetas compartidas está caído. Revisar por favor.'
            ]
        ];

        foreach ($mockEmails as $email) {
            $user = User::where('email', $email['from'])->first();
            
            if ($user) {
                Ticket::create([
                    'title' => $email['subject'],
                    'description' => $email['body'],
                    'user_id' => $user->id,
                    'status' => 'abierto',
                    'priority' => 'alta'
                ]);
                $this->info('✅ Ticket generado desde EMAIL: ' . $email['subject']);
            } else {
                $this->warn('❌ Usuario no reconocido: ' . $email['from']);
            }
        }

        $this->success('📡 Procesamiento de correos completado.');
    }
}
