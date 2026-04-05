<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\ActivityLog;

class TicketService
{
    public function createTicket(array $data, $userId)
    {
        $ticket = Ticket::create(array_merge($data, [
            'user_id' => $userId,
            'status_id' => 1, // Open
        ]));

        $this->logActivity('created', $ticket, $userId, ['title' => $ticket->title]);

        return $ticket;
    }

    public function replyToTicket(Ticket $ticket, $body, $userId, $isInternal = false)
    {
        $reply = $ticket->replies()->create([
            'user_id' => $userId,
            'body' => $body,
            'is_internal' => $isInternal
        ]);

        if (!$isInternal) {
            // Update ticket status dynamically if technical answers it could be "In Progress" or "Pending User"
            // For now simply log
        }

        $this->logActivity('replied', $ticket, $userId);

        return $reply;
    }

    public function updateStatus(Ticket $ticket, $statusId, $userId)
    {
        $oldStatus = $ticket->status_id;
        $ticket->update(['status_id' => $statusId]);

        // If closed or resolved, handle dates
        $status = \App\Models\Status::find($statusId);
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

    private function logActivity($action, $model, $userId, $details = [])
    {
        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'details' => json_encode($details),
            'ip_address' => request()->ip()
        ]);
    }
}
