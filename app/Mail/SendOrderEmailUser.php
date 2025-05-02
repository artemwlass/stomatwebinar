<?php

namespace App\Mail;

use App\Models\DefaultMessageWebinarOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOrderEmailUser extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $user;
    public $defaultMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
        $this->user = User::find($this->event->order->user_id);

        $rawMessage = optional(DefaultMessageWebinarOrder::first())->message ?? '';
        $this->defaultMessage = $this->parseDefaultMessage($rawMessage);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Замовлення stomatwebinar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.send-order-email-user',
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

    private function parseDefaultMessage(string $message): string
    {
        return str_replace(
            ['[NAME]', '[DESCRIPTION]'],
            [
                $this->user->name,
                $this->event->order->description ?? '',
            ],
            $message
        );
    }
}
