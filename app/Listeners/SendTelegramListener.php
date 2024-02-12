<?php

namespace App\Listeners;

use App\Events\SendTelegram;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTelegramListener
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
    public function handle(SendTelegram $event): void
    {

        \Illuminate\Support\Facades\Http::post('https://api.telegram.org/bot'.env('TOKEN_TELEGRAM').'/sendMessage',
            [
                'chat_id' => env('CHAT_ID_TELEGRAM'),
                'text' => (string) view('send-telegram.index', compact('event')),
                'parse_mode' => 'html',
            ]);
    }
}
