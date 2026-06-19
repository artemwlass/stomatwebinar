<?php

namespace App\Livewire\Payment;

use App\Models\PaymentAttempt;
use App\Support\PromoCodeCalculator;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Payment extends Component
{
    public string $paymentToken = '';

    public function mount($token)
    {
        if (session('payment_token') !== $token) {
            // Если токен не соответствует или отсутствует, редирект или ошибка
            return redirect()->to('/');
        }

        $this->paymentToken = $token;
    }

    public function render()
    {
        $attempt = PaymentAttempt::where('payment_token', $this->paymentToken)->first();
        $cart = [];

        if (!$attempt) {
            $webinarNames = [];

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
                    'is_series' => $item->options->is_series,
                    'user_id' => auth()->id(),
                ];
            }

            if (count($cart) === 0) {
                return redirect()->to('/');
            }

            $originalAmount = PromoCodeCalculator::cartSubtotal();
            $discountData = PromoCodeCalculator::discountData(session('cart_promo_code'), $originalAmount);
            $purchaseAmount = $discountData['total_amount'];
            $formattedPurchaseAmount = number_format($purchaseAmount, 2, '.', '');
            $webinarsString = "Оплата вебинара - " . implode(', ', $webinarNames) . '.';
            $liqpayOrderId = 'order_' . $this->paymentToken;
            $authUser = auth()->user();
            $attributionData = session('attribution');

            if (empty($attributionData)) {
                $fromCookie = request()->cookie('attribution_data');
                $decoded = is_string($fromCookie) ? json_decode($fromCookie, true) : null;
                $attributionData = is_array($decoded) ? $decoded : null;
            }

            $attempt = PaymentAttempt::create([
                'user_id' => auth()->id(),
                'payment_token' => $this->paymentToken,
                'liqpay_order_id' => $liqpayOrderId,
                'amount' => $formattedPurchaseAmount,
                'currency' => 'UAH',
                'promo_code' => $discountData['promo_code'],
                'discount_amount' => $discountData['discount_amount'],
                'original_amount' => $originalAmount,
                'status' => 'pending',
                'description' => $webinarsString,
                'user_email' => $authUser?->email,
                'user_phone' => $authUser?->phone,
                'user_name' => $authUser?->name,
                'user_surname' => $authUser?->surname,
                'attribution_data' => $attributionData,
                'cart_data' => $cart,
            ]);

            \Gloudemans\Shoppingcart\Facades\Cart::destroy();
            session()->forget('cart_promo_code');
        } else {
            $cart = $attempt->cart_data ?? [];
        }

        $formattedPurchaseAmount = number_format((float)$attempt->amount, 2, '.', '');

        $data = [
            'version'       => 3,
            'public_key'    => env('LIQPAY_PUBLIC_KEY'),
            'action'        => 'pay',
            'amount'        => $formattedPurchaseAmount,
            'currency'      => 'UAH',
            'description'   => $attempt->description,
            'order_id'      => $attempt->liqpay_order_id,
            'server_url'    => route('api.callback.liqpay'),
            'dae'           => base64_encode(json_encode($cart))
        ];

        $dataEncoded = base64_encode(json_encode($data));
        $signature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $dataEncoded . env('LIQPAY_PRIVATE_KEY'), true));

        \Gloudemans\Shoppingcart\Facades\Cart::destroy();

        return view('livewire.payment.paymant', compact('dataEncoded', 'signature', 'formattedPurchaseAmount'))
            ->layout('components.layouts.payment');
    }
}
