<?php

namespace App\Mail;

use App\Models\WebinarTestResult;
use App\Support\CertificatePdf;
use App\Support\CertificatePresenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public WebinarTestResult $result)
    {
        $this->result->loadMissing(['user', 'webinar']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваш сертифікат stomatwebinar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.certificate',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => CertificatePdf::make($this->result)->output(),
                CertificatePresenter::fileName($this->result),
            )->withMime('application/pdf'),
        ];
    }
}
