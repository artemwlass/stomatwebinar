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

    #[On('formOrder')]
    public function store($formData)
    {
        $this->name = $formData['name'];
        $this->phone = $formData['phone'];
        $this->email = $formData['email'];
        $this->surname = $formData['surname'];


        // Валидация входных данных
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'surname' => 'required|string',
        ]);
        // Предположим, что $this->email уже заполнен
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            // Пользователь не найден, создаем нового
            $user = User::create([
                'name' => $this->name,
                'surname' => $this->surname,
                'phone' => $this->phone,
                'email' => $this->email,
                'password' => Hash::make('vYjDsM7kkZ'), // Установите безопасный пароль
            ]);
        } else {
            // Пользователь найден, проверяем наличие фамилии и телефона

            if (!$user->surname) {
                $user->surname = $this->surname;
            }
            if (!$user->phone) {
                $user->phone = $this->phone;
            }
            $user->save();
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
