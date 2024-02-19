<?php

namespace App\Listeners;

use App\Events\SendOrderTelegram;
use App\Models\OrderWebinars;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderTelegramListener
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
    public function handle(SendOrderTelegram $event): void
    {
        $user = User::find($event->order->user_id);
        $webinars = OrderWebinars::with('webinar')
            ->where('order_id', $event->order->id)
            ->get();

        \Illuminate\Support\Facades\Http::post('https://api.telegram.org/bot'.env('TOKEN_TELEGRAM').'/sendMessage',
            [
                'chat_id' => env('CHAT_ID_TELEGRAM'),
                'text' => (string) view('send-telegram.order', compact('event', 'user', 'webinars')),
                'parse_mode' => 'html',
            ]);
    }
}
