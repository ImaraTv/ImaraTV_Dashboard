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

class CreatorSponsorRegisteredEmail extends Mailable
{

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ?string $profile_link, public User $admin, public User $user, public $role)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $role = $this->role;
        return new Envelope(
                subject: 'New ' . $role. ' has Registered at Imara TV',
                from: new Address(env('MAIL_FROM_ADDRESS'), 'Imara TV')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
                markdown: 'emails.creator-sponsor-registered',
                with:
                [
                    'link' => $this->profile_link,
                    'name' => $this->admin->name,
                    'user' => $this->user,
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
