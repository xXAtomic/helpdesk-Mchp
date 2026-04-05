<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\ActivityLog;

class TicketService
{
<<<<<<< HEAD
    public function createTicket(array $data, $userId, $attachments = [])
=======
    public function createTicket(array $data, $userId)
>>>>>>> origin/servidor-maraton-ayer
    {
        $ticket = Ticket::create(array_merge($data, [
            'user_id' => $userId,
            'status_id' => 1, // Open
        ]));

<<<<<<< HEAD
        if (!empty($attachments)) {
            $this->handleAttachments($ticket, $attachments);
        }

=======
>>>>>>> origin/servidor-maraton-ayer
        $this->logActivity('created', $ticket, $userId, ['title' => $ticket->title]);

        return $ticket;
    }

<<<<<<< HEAD
    public function replyToTicket(Ticket $ticket, $body, $userId, $isInternal = false, $attachments = [])
=======
    public function replyToTicket(Ticket $ticket, $body, $userId, $isInternal = false)
>>>>>>> origin/servidor-maraton-ayer
    {
        $reply = $ticket->replies()->create([
            'user_id' => $userId,
            'body' => $body,
            'is_internal' => $isInternal
        ]);

<<<<<<< HEAD
        if (!empty($attachments)) {
            $this->handleAttachments($ticket, $attachments, $reply->id);
        }

        if (!$isInternal) {
            // Log logic here if needed
=======
        if (!$isInternal) {
            // Update ticket status dynamically if technical answers it could be "In Progress" or "Pending User"
            // For now simply log
>>>>>>> origin/servidor-maraton-ayer
        }

        $this->logActivity('replied', $ticket, $userId);

        return $reply;
    }

    public function updateStatus(Ticket $ticket, $statusId, $userId)
    {
        $oldStatus = $ticket->status_id;
        $ticket->update(['status_id' => $statusId]);

        // If closed or resolved, handle dates
<<<<<<< HEAD
        $status = \App\Models\TicketStatus::find($statusId);
=======
        $status = \App\Models\Status::find($statusId);
>>>>>>> origin/servidor-maraton-ayer
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

<<<<<<< HEAD
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

=======
>>>>>>> origin/servidor-maraton-ayer
    private function logActivity($action, $model, $userId, $details = [])
    {
        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
<<<<<<< HEAD
            'details' => $details,
=======
            'details' => json_encode($details),
>>>>>>> origin/servidor-maraton-ayer
            'ip_address' => request()->ip()
        ]);
    }
}
