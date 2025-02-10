<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessagePreorderWebinarFree extends Mailable
{
    use Queueable, SerializesModels;

    public $text;
    public $webinar;

    /**
     * Create a new message instance.
     */
    public function __construct($webinar)
    {
        $this->webinar = $webinar;
        $rawText = \App\Models\MessagePreorderWebinarFree::first()->text;

        // Заменяем плейсхолдеры на реальные значения
        $this->text = strtr($rawText, [
            '[NAME]' => $webinar->name,
            '[DATE]' => $webinar->content['date'] . ' о ' . $webinar->content['time']
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Реєстрація на вебінар',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.message-preorder-webinar-free',
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
