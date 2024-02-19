<?php

namespace App\Listeners;

use App\Events\SendRegisterEmailUser;
use App\Mail\SendRegisterUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendregisterEmailUserListener
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
    public function handle(SendRegisterEmailUser $event): void
    {
        Mail::to($event->user->email)->send(new SendRegisterUser($event));
    }
}
