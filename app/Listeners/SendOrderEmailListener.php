<?php

namespace App\Listeners;

use App\Events\SendOrderEmail;
use App\Mail\Support;
use App\Models\EmailAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendOrderEmail $event): void
    {
        $emails = EmailAdmin::all();
        if ($emails) {
            foreach ($emails as $email) {
                Mail::to($email->email)->send(new Support($event));
            }
        }
    }
}
