<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($mailMessage, $subject)
    {
        $this->mailMessage = $mailMessage;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), 'SEU BOLETO ESTÁ DISPONÍVEL PARA PAGAMETO!'),
            replyTo: [
                new Address(env('MAIL_FROM_ADDRESS'), 'SEU BOLETO ESTÁ DISPONÍVEL PARA PAGAMETO!')
            ],
            subject: $this->subject

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail',
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
