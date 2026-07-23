<?php

namespace App\Mail;

use App\Models\DefaultMessagePurchaseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRegisterUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $event;
    public string $body;

    /**
     * Create a new message instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
        $rawMessage = optional(DefaultMessagePurchaseRegistration::first())->message ?? $this->defaultMessage();
        $this->body = $this->parseMessage($rawMessage);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Реєстрація на stomatwebinar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.send-register-email-user',
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

    private function parseMessage(string $message): string
    {
        return str_replace(
            ['[NAME]', '[EMAIL]', '[PASSWORD]'],
            [
                $this->event->user->name,
                $this->event->user->email,
                $this->event->password,
            ],
            $message
        );
    }

    private function defaultMessage(): string
    {
        return 'Шановний(а) [NAME],<br><br>Дякуємо Вам за реєстрацію на сайті.<br><br>Ваш логін: [EMAIL]<br>Пароль: [PASSWORD]<br><br><br>З повагою,<br>Команда stomatwebinar.com<br>stomatwebinar30@gmail.com<br>+380 99 092 64 45<br>';
    }
}
