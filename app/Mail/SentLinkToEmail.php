<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SentLinkToEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __("Vatandoshlar"),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if (Cache::has($this->data['token'])) {
            $data = Cache::get($this->data['token']);
            $token = $data['token'];
        }
        return new Content(
            view: 'email',
            with: [
                'url' => env('SEND_LINK_TO_EMAIL') . "/api/verify/?token=$token"
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
