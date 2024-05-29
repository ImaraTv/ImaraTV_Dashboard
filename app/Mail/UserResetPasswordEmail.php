<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\{
    Bus\Queueable,
    Mail\Mailable,
    Mail\Mailables\Content,
    Mail\Mailables\Envelope,
    Queue\SerializesModels
};

class UserResetPasswordEmail extends Mailable
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
                subject: 'Reset Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
                markdown: 'emails.user-reset-password',
                with:
                [
                    'actionUrl' => $this->url,
                    'name' => $this->user->name,
                    'level' => 'success',
                    'actionText' => 'Reset Password',
                    'displayableActionUrl' => $this->url
                ]
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
