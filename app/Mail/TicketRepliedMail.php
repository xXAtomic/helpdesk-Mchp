<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketRepliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $reply;

    public function __construct(Ticket $ticket, TicketResponse $reply)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualización en su Solicitud #' . $this->ticket->ticket_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_replied',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
