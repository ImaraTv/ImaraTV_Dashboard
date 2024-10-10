<?php

namespace App\Mail;

use App\Models\CreatorProposal;
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

class SponsorExpressionOfInterestEmail extends Mailable
{

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public CreatorProposal $proposal, public ?User $user = null, public bool $is_admin = false)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
                subject: 'Sponsor Expression of Interest',
                from: new Address(env('MAIL_FROM_ADDRESS'), 'Imara TV')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
                markdown: 'emails.film-eoi-submitted',
                with:
                [
                    'level' => 'success',
                    'is_admin' => $this->is_admin,
                    'name' => $this->is_admin ? 'Admin' : $this->user->name,
                    'proposal' => $this->proposal,
                    'sponsor' => $this->user,
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
