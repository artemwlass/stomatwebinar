<?php

namespace App\Livewire\Payment;

use App\Models\PaymentAttempt;
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

            $subtotalRaw = (string)\Gloudemans\Shoppingcart\Facades\Cart::subtotal();
            $subtotalSanitized = preg_replace('/[^\d.,]/', '', $subtotalRaw);
            $lastCommaPosition = strrpos($subtotalSanitized, ',');
            $lastDotPosition = strrpos($subtotalSanitized, '.');

            if ($lastCommaPosition !== false && $lastDotPosition !== false) {
                if ($lastCommaPosition > $lastDotPosition) {
                    $subtotalSanitized = str_replace('.', '', $subtotalSanitized);
                    $subtotalSanitized = str_replace(',', '.', $subtotalSanitized);
                } else {
                    $subtotalSanitized = str_replace(',', '', $subtotalSanitized);
                }
            } elseif ($lastCommaPosition !== false) {
                $subtotalSanitized = str_replace(',', '.', $subtotalSanitized);
            }

            $purchaseAmount = round((float)$subtotalSanitized, 2);
            $formattedPurchaseAmount = number_format($purchaseAmount, 2, '.', '');
            $webinarsString = "Оплата вебинара - " . implode(', ', $webinarNames) . '.';
            $liqpayOrderId = 'order_' . $this->paymentToken;
            $authUser = auth()->user();

            $attempt = PaymentAttempt::create([
                'user_id' => auth()->id(),
                'payment_token' => $this->paymentToken,
                'liqpay_order_id' => $liqpayOrderId,
                'amount' => $formattedPurchaseAmount,
                'currency' => 'UAH',
                'status' => 'pending',
                'description' => $webinarsString,
                'user_email' => $authUser?->email,
                'user_phone' => $authUser?->phone,
                'user_name' => $authUser?->name,
                'user_surname' => $authUser?->surname,
                'cart_data' => $cart,
            ]);

            \Gloudemans\Shoppingcart\Facades\Cart::destroy();
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
            'dae'           => base64_encode(json_encode($cart))
        ];

        $dataEncoded = base64_encode(json_encode($data));
        $signature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $dataEncoded . env('LIQPAY_PRIVATE_KEY'), true));

        \Gloudemans\Shoppingcart\Facades\Cart::destroy();

        return view('livewire.payment.paymant', compact('dataEncoded', 'signature', 'formattedPurchaseAmount'))
            ->layout('components.layouts.payment');
    }
}
