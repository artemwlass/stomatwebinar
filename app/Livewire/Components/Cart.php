<?php

namespace App\Livewire\Components;

use App\Livewire\LiqPay\PaymentForm;
use App\Services\Liqpay;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Cart extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function destroy($id)
    {
        \Gloudemans\Shoppingcart\Facades\Cart::remove($id);
        $this->dispatch('cartUpdated');
    }

    public function mount()
    {
//        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
//        $html = $liqpay->cnb_form(array(
//            'action'         => 'pay',
//            'amount'         => '1',
//            'currency'       => 'USD',
//            'description'    => 'description text',
//            'order_id'       => 'order_id_1',
//            'version'        => '3'
//        ));
    }

    public function store()
    {
//        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
//        $html = $liqpay->cnb_form(array(
//            'action'         => 'pay',
//            'amount'         => '1',
//            'currency'       => 'USD',
//            'description'    => 'description text',
//            'order_id'       => 'order_id_1',
//            'version'        => '3'
//        ));
//        $this->redirect('/payment-form');
//        return view('liqpay.payment-form', ['form' => $html]);
    }

    public function render()
    {
        $webinarNames = [];

        foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item) {
            $webinarNames[] = $item->name;
        }

        $webinarsString = "Оплата вебинара - " . implode(', ', $webinarNames) . '.';
        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
        $payForm = $liqpay->cnb_form(array(
            'action'         => 'pay',
            'amount'         => \Gloudemans\Shoppingcart\Facades\Cart::subtotal(),
            'currency'       => 'UAH',
            'description'    => $webinarsString,
            'order_id'       => 'order_id_15',
            'version'        => '3',
            'result_url'     => 'https://stomatwebinar.com/',
            'server_url'     => 'https://stomatwebinar.com/api/test'
        ));
        return view('livewire.components.cart', compact('payForm'));
    }
}
