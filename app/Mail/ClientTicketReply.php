<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientTicketReply extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Client Ticket Reply',
        );
    }
    public function build()
    {
        return $this->markdown('emails.client.client_ticket_reply')
            ->subject('Client Ticket Reply');
    }
}
