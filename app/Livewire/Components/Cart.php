<?php

namespace App\Livewire\Components;

use App\Livewire\LiqPay\PaymentForm;
use App\Livewire\Payment\Payment;
use App\Models\User;
use App\Services\Liqpay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
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

    public function store()
    {
        // Предположим, что $this->email уже заполнен
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            // Пользователь не найден, создаем нового
            $user = User::create([
                'name' => $this->name,
                'surname' => $this->surname,
                'phone' => $this->phone,
                'email' => $this->email,
                'password' => Hash::make('defaultPassword'), // Установите безопасный пароль
            ]);
        }else {
            // Пользователь найден, проверяем наличие фамилии и телефона
            $updateData = [];
            if (empty($user->surname) && !empty($this->surname)) {
                $updateData['surname'] = $this->surname;
            }
            if (empty($user->phone) && !empty($this->phone)) {
                $updateData['phone'] = $this->phone;
            }

            // Обновляем данные пользователя, если необходимо
            if (!empty($updateData)) {
                $user->update($updateData);
            }
        }

        // Авторизация пользователя
        Auth::login($user);
        $paymentToken = Str::random(32);
        session(['payment_token' => $paymentToken]);
        return redirect()->to('/payment-form/' . $paymentToken);
    }

    public function render()
    {
        return view('livewire.components.cart');
    }
}
