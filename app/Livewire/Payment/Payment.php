<?php

namespace App\Livewire\Payment;

use App\Events\SendEmail;
use App\Events\SendEmailPreorder;
use App\Events\SendOrderEmail;
use App\Events\SendOrderTelegram;
use App\Listeners\SendOrderEmailListener;
use App\Livewire\Components\Cart;
use App\Models\GroupUser;
use App\Models\Order;
use App\Models\OrderWebinars;
use App\Models\User;
use App\Services\Liqpay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;
use Revolution\Google\Sheets\Facades\Sheets;

class Payment extends Component
{
    public function mount($token)
    {
        if (session('payment_token') !== $token) {
            // Если токен не соответствует или отсутствует, редирект или ошибка
            return redirect()->to('/');
        }
    }
    #[On('payment')]
    public function createOrder($formData)
    {
        $timestampMilliseconds = $formData['create_date'];
        $timestampSeconds = $timestampMilliseconds / 1000;

        $order = new Order;
        $order->user_id = Auth::id();
        $order->payment_id = $formData['payment_id'] ?? null;
        $order->amount = $formData['amount'] ?? null;
        $order->transaction_id = $formData['transaction_id'] ?? null;
        $order->status = $formData['status'] ?? null;
        $order->paytype = $formData['paytype'] ?? null;
        $order->payment_created_at = Carbon::createFromTimestamp($timestampSeconds); // Текущее время как время создания платежа
        $order->description = $formData['description'] ?? null;
        $order->save();

        foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item) {
            $groupId = $item->model->group->id;
            $userId = auth()->id(); // ID текущего пользователя

            // Проверка, не добавлен ли уже пользователь в эту группу
            $existingGroupUser = GroupUser::where('group_id', $groupId)
                ->where('user_id', $userId)
                ->first();

            if (!$existingGroupUser) {
                // Создание новой записи в group_users
                GroupUser::create([
                    'group_id' => $groupId,
                    'user_id' => $userId,
                    'closed_webinar_date' => Carbon::now()->addDays(31)->format('Y-m-d')
                ]);
            }

            $webinar = OrderWebinars::create([
                'order_id' => $order->id,
                'user_id' => $userId,
                'webinar_id' => $item->id,
                'price' => $item->price,
            ]);

            if ($item->model->is_preorder == true) {
                try {
                    event(new SendEmailPreorder($order, $webinar));
                } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                    Log::error("Ошибка отправки почты: " . $e->getMessage());
                }

            } else {
                try {
                    event(new SendOrderEmail($order));
                } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                    Log::error("Ошибка отправки почты: " . $e->getMessage());
                }
            }
        }

//        \Gloudemans\Shoppingcart\Facades\Cart::destroy();
//
//        event(new SendOrderTelegram($order));
//
//        Session::forget('payment_token');
//
//        $this->addToSheet($order->description, $order->amount, $order->created_at);
//
//        return redirect()->to('/account');
    }

    public function addToSheet($order_description, $order_amount, $order_created_at)
    {
        $user = User::find(Auth::id());
        $data = [
            "Имя" => $user->name,
            "Фамилия" => $user->surname,
            "Почта" => $user->email,
            "Телефон" => $user->phone,
            "Заказ" => $order_description,
            "Стоимость" => $order_amount,
            "Дата и время" => Carbon::parse($order_created_at)->format('Y-m-d H:i:s'),
        ];

        // ID вашей Google таблицы
        $spreadsheetId = '1-eU30QRhoPt-Y_A_5Gy5xaCkzkL5tU6Yxvr4VL9rLpw';

        // Название листа в таблице
        $sheetName = '2024';

        // Получение доступа к таблице
        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);

        // Добавление данных в таблицу
        $sheet->append([$data]);
    }
    public function render()
    {
        $webinarNames = [];
        $items = [];

        foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item) {
            $webinarNames[] = $item->name;
        }

        $webinarsString = "Оплата вебинара - " . implode(', ', $webinarNames) . '.';

        $data = [
            'version'       => 3,
            'public_key'    => env('LIQPAY_PUBLIC_KEY'),
            'action'        => 'pay',
            'amount'        => \Gloudemans\Shoppingcart\Facades\Cart::subtotal(),
            'currency'      => 'UAH',
            'description'   => $webinarsString,
            'order_id'      => 'order_' . date('YmdHis'),
        ];

        $dataEncoded = base64_encode(json_encode($data));
        $signature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $dataEncoded . env('LIQPAY_PRIVATE_KEY'), true));

        return view('livewire.payment.paymant', compact('dataEncoded', 'signature'))->layout('components.layouts.payment');
    }
}
