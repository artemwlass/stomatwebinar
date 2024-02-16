<?php

namespace App\Livewire\Components;

use App\Livewire\LiqPay\PaymentForm;
use App\Services\Liqpay;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Cart extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];
    public $name;
    public $phone;
    public $surname;
    public $email;

    public function destroy($id)
    {
        \Gloudemans\Shoppingcart\Facades\Cart::remove($id);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $webinarNames = [];
        $items = [];

        foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item) {
            $webinarNames[] = $item->name;

            $items[] = [
                'name'     => $item->name,
                'price'    => $item->price,
                'id' => $item->id,
                // Добавьте здесь другие необходимые поля, если они есть
            ];
        }


        $webinarsString = "Оплата вебинара - " . implode(', ', $webinarNames) . '.';
        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
        $payForm = $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => \Gloudemans\Shoppingcart\Facades\Cart::subtotal(),
            'currency'       => 'UAH',
            'description'    => $webinarsString,
            'order_id'       => 'order_' . date('YmdHis'),
            'version'        => '3',
            'result_url'     => 'https://stomatwebinar.com/',
            'server_url'     => 'https://stomatwebinar.com/api/result-payment',
            'rro_info'       => $items
        ));
        return view('livewire.components.cart', compact('payForm'));
    }
}
