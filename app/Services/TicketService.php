<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\ActivityLog;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketRepliedMail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    public function createTicket(array $data, $userId, $attachments = [])
    {
        $ticket = Ticket::create(array_merge($data, [
            'user_id' => $userId,
            'status_id' => 1, // Open
        ]));

        if (!empty($attachments)) {
            $this->handleAttachments($ticket, $attachments);
        }

        $this->logActivity('created', $ticket, $userId, ['title' => $ticket->title]);
        
        // --- 📧 NOTIFICACIÓN AUTOMÁTICA POR CORREO ---
        if($ticket->user && $ticket->user->email){
            try {
                Mail::to($ticket->user->email)->send(new TicketCreatedMail($ticket));
            } catch (\Exception $e) {
                Log::error('FE fallo envio correo: ' . $e->getMessage());
            }
        }

        return $ticket;
    }

    public function replyToTicket(Ticket $ticket, $body, $userId, $isInternal = false, $attachments = [])
    {
        $reply = $ticket->replies()->create([
            'user_id' => $userId,
            'body' => $body,
            'is_internal' => $isInternal
        ]);

        if (!empty($attachments)) {
            $this->handleAttachments($ticket, $attachments, $reply->id);
        }

        $this->logActivity('replied', $ticket, $userId);

        // --- 📧 NOTIFICACIONES POR CORREO ---
        if (!$isInternal) {
            // Si el que responde NO es el dueño (es un técnico), notificar al dueño
            if ($userId != $ticket->user_id) {
                if ($ticket->user && $ticket->user->email) {
                    try {
                        Mail::to($ticket->user->email)->send(new TicketRepliedMail($ticket, $reply));
                    } catch (\Exception $e) {
                         Log::error('Error mail reply user: ' . $e->getMessage());
                    }
                }
            } 
            // Si el que responde ES el dueño, notificar al técnico asignado (si existe)
            else if ($ticket->technician && $ticket->technician->email) {
                try {
                    Mail::to($ticket->technician->email)->send(new TicketRepliedMail($ticket, $reply));
                } catch (\Exception $e) {
                    Log::error('Error mail reply tech: ' . $e->getMessage());
                }
            }
        }

        return $reply;
    }

    public function updateStatus(Ticket $ticket, $statusId, $userId)
    {
        $oldStatus = $ticket->status_id;
        $ticket->update(['status_id' => $statusId]);

        $status = \App\Models\TicketStatus::find($statusId);
        if ($status && $status->is_closed) {
            $ticket->update(['closed_at' => now(), 'resolved_at' => now()]);
        }

        $this->logActivity('status_changed', $ticket, $userId, [
            'old_status' => $oldStatus, 
            'new_status' => $statusId
        ]);

        return $ticket;
    }

    public function assignTechnician(Ticket $ticket, $technicianId, $userId)
    {
        $oldTech = $ticket->technician_id;
        $ticket->update(['technician_id' => $technicianId]);

        $this->logActivity('assigned', $ticket, $userId, [
            'old_technician' => $oldTech,
            'new_technician' => $technicianId
        ]);

        return $ticket;
    }

    public function handleAttachments(Ticket $ticket, array $files, $responseId = null)
    {
        foreach ($files as $file) {
            $path = $file->store('attachments/' . $ticket->id, 'public');
            
            $ticket->attachments()->create([
                'ticket_response_id' => $responseId,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }

    /**
     * Registra la valoración (CSAT) de un ticket cerrado.
     */
    public function rateTicket(Ticket $ticket, array $data, $userId)
    {
        if ($ticket->rating) {
            throw new \Exception('Este incidente ya ha sido valorado.');
        }

        $rating = $ticket->rating()->create([
            'user_id' => $userId,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        $this->logActivity('rated', $ticket, $userId, ['stars' => $data['rating']]);

        return $rating;
    }

    private function logActivity($action, $model, $userId, $details = [])
    {
        try {
            // Solo registrar si la tabla existe para evitar errores 500 prematuros
            if (Schema::hasTable('activity_logs')) {
                ActivityLog::create([
                    'user_id' => $userId,
                    'action' => $action,
                    'model_type' => get_class($model),
                    'model_id' => $model->id,
                    'details' => $details,
                    'ip_address' => request()->ip()
                ]);
            }
        } catch (\Exception $e) {
            // Registrar el error en logs internos pero no interrumpir la experiencia del usuario
            Log::warning('ActivityLog Error: ' . $e->getMessage());
        }
    }
}
