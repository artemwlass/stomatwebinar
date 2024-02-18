<?php

namespace App\Livewire\Payment;

use App\Events\SendEmail;
use App\Events\SendOrderEmail;
use App\Events\SendOrderTelegram;
use App\Listeners\SendOrderEmailListener;
use App\Livewire\Components\Cart;
use App\Models\GroupUser;
use App\Models\Order;
use App\Services\Liqpay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

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
        }

        \Gloudemans\Shoppingcart\Facades\Cart::destroy();

        event(new SendOrderEmail($order));
        event(new SendOrderTelegram($order));

        Session::forget('payment_token');

        return redirect()->to('/account');
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
