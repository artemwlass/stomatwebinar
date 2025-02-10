<?php

namespace App\Mail;

use App\Models\FreeWebinarPreorder;
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
    public function __construct($webinar_id)
    {
        $this->webinar = FreeWebinarPreorder::find($webinar_id);

        if (!$this->webinar) {
            throw new \Exception('Вебинар не найден');
        }

        $rawText = \App\Models\MessagePreorderWebinarFree::first()->text;


        // Переменные по умолчанию
        $date = "не указано";
        $time = "не указано";

        // Ищем блок с type == 0
        foreach ($this->webinar->content as $item) {
            if (isset($item['type']) && $item['type'] == "0") {
                $date = $item['date'] ?? "не указано";
                $time = $item['time'] ?? "не указано";
                break; // Выходим из цикла после нахождения нужного элемента
            }
        }

        // Заменяем плейсхолдеры на реальные значения
        $this->text = strtr($rawText, [
            '[NAME]' => $this->webinar->name,
            '[DATE]' => "$date о $time"
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
