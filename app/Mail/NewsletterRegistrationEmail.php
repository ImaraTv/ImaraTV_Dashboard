<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\{
    Bus\Queueable,
    Mail\Mailable,
    Mail\Mailables\Address,
    Mail\Mailables\Content,
    Mail\Mailables\Envelope,
    Queue\SerializesModels
};
use function env;

class NewsletterRegistrationEmail extends Mailable
{

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $email)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
                subject: 'Welcome to Imara TV Newsletter',
                from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Imara TV'))
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
                markdown: 'emails.newsletter-registration',
                with:
                [
                    'level' => 'success',
                    'email' => $this->email,
                    'actionText' => '',
                    'actionUrl' => '',
                ],
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
