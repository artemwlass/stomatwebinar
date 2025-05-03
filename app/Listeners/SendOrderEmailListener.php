<?php

namespace App\Listeners;

use App\Events\SendOrderEmail;
use App\Mail\SendOrderEmailAdmin;
use App\Mail\SendOrderEmailUser;
use App\Mail\Support;
use App\Models\EmailAdmin;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
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
                Mail::to($email->email)->send(new SendOrderEmailAdmin($event));
            }
        }
        $user = User::find($event->order->user_id);
        Mail::to($user->email)->send(new SendOrderEmailUser($event, $event->webinar));

    }
}
