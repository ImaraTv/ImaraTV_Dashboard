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

class UserRegistrationEmail extends Mailable
{

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ?string $url, public User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
                subject: 'Registration Email',
                from: new Address(env('MAIL_FROM_ADDRESS'), 'Imara TV')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
                markdown: 'emails.user-register',
                with:
                [
                    'level' => 'success',
                    'actionUrl' => $this->url,
                    'name' => $this->user->name,
                    'actionText' => 'Verify Account',
                    'displayableActionUrl'=> $this->url
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
