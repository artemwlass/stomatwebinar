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

    public function render()
    {
        $webinarNames = [];
        $items = [];
        $cart = [];

        foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item) {
            $webinarNames[] = $item->name;
        }

        foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item) {
            $cart[] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->qty,
                'group_id' => $item->model->group->id,
                'is_preorder' => $item->model->is_preorder,
                'user_id' => auth()->id(),
            ];
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
            'dae'           => base64_encode(json_encode($cart))
        ];

        $dataEncoded = base64_encode(json_encode($data));
        $signature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $dataEncoded . env('LIQPAY_PRIVATE_KEY'), true));

        \Gloudemans\Shoppingcart\Facades\Cart::destroy();

        return view('livewire.payment.paymant', compact('dataEncoded', 'signature'))->layout('components.layouts.payment');
    }
}
