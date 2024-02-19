<?php

namespace App\Listeners;

use App\Events\SendEmailOpenWebinarFromAdmin;
use App\Mail\SendRegisterUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailOpenWebinarFromAdminListener
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
    public function handle(SendEmailOpenWebinarFromAdmin $event): void
    {
        Mail::to($event->record->email)->send(new \App\Mail\SendEmailOpenWebinarFromAdmin($event));
    }
}
