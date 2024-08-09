<?php

namespace App\Mail;

use App\Models\CreatorProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VimeoUploadComplete extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public CreatorProposal $proposal, public string $video_title, public string $video_id)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $video_title = $this->video_title;
        return new Envelope(
            subject: 'Vimeo Upload Completed for ' . $video_title
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.vimeo-upload-complete',
            with:
            [
                'level' => 'success',
                'name' => 'Admin',
                'proposal_title' => $this->proposal->working_title,
                'video_title' => $this->video_title,
                'video_id' => $this->video_id,
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
