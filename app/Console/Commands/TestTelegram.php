<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Liqpay;
use Carbon\Carbon;
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
        $today = Carbon::today();

// Получение всех пользователей, которые привязаны к группам с потенциально истекшей датой
        $users = User::whereHas('groups', function ($query) use ($today) {
            $query->where('closed_webinar_date', '<=', $today);
        })->get();

        foreach ($users as $user) {
            // Для каждого пользователя получаем группы
            $groups = $user->groups()->get();

            foreach ($groups as $group) {
                // Проверяем, что дата закрытия меньше или равна текущей дате
                if (Carbon::parse($group->pivot->closed_webinar_date)->endOfDay() < $today) {
                    // Отвязываем пользователя от группы
                    $user->groups()->detach($group->id);
                }
            }
        }

//        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
//        $html = $liqpay->cnb_form(array(
//            'action'         => 'pay',
//            'amount'         => '1',
//            'currency'       => 'USD',
//            'description'    => 'description text',
//            'order_id'       => 'order_id_1',
//            'version'        => '3'
//        ));
//        dd($html);
//        Mail::raw('Это тестовое письмо.', function ($message) {
//            $message->to('artem.yablochnyi@gmail.com') // Замените на ваш тестовый email
//            ->subject('Тестовое письмо');
//        });
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
