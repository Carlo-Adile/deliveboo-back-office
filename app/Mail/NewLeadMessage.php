<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $istance;
    public $isUser;

    /**
     * Create a new message instance.
     */
    //utilizzo il costruttore per la nuova email
    public function __construct($order, $istance, $isUser)
    {
        $this->order = $order;
        $this->istance = $istance;
        $this->isUser = $isUser;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        //qui vedo il corpo del messaggio
        return new Envelope(
            subject: $this->isUser ? 'Ordine confermato' : 'Hai ricevuto un nuovo ordine',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-lead-message',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
