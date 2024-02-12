<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::raw('Это тестовое письмо.', function ($message) {
            $message->to('artem.yablochnyi@gmail.com') // Замените на ваш тестовый email
            ->subject('Тестовое письмо');
        });
//        $token = '6712945282:AAFn79b5gTPTfz7ZWjdc3CEP4wJ6IA_lmKA';
//        $chat = '-314287591';
//       dd( \Illuminate\Support\Facades\Http::post('https://api.telegram.org/bot'.$token.'/sendMessage',
//            [
//                'chat_id' => $chat,
//                'text' => 'test',
//            ])->json()
//    );
    }
}
