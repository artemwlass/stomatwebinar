<?php

namespace App\Mail;

use App\Models\DefaultMessageWebinar;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailPreorder extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $user;
    public $webinar;
    public $defaultMessage;
    /**
     * Create a new message instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
        $this->user = User::find($this->event->order->user_id);
        $this->webinar = Webinar::find($event->webinar->webinar_id);

        $rawMessage = optional(DefaultMessageWebinar::first())->message ?? '';
        $this->defaultMessage = $this->parseDefaultMessage($rawMessage);
    }

    private function parseDefaultMessage($message)
    {
        return str_replace(
            ['[NAME]', '[NAMEWEBINAR]', '[DATE]', '[TIME]'],
            [$this->user->name, $this->webinar->title, $this->webinar->date_preorder, $this->webinar->time_preorder],
            $message
        );
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
            view: 'mail.send-preorder-email-user',
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
