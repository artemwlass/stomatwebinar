<?php

namespace App\Livewire\Auth;

use App\Events\SendRegisterEmailUser;
use App\Livewire\Account\Index;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{

    public $name;
    public $city;
    public $password;
    public $email;
    public $politic_success;

    public function register()
    {
        $this->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'politic_success' => 'required',
        ], [
            'name' => 'Поле Ім\'я обов\'язкове для заповнення.',
            'city' => 'Поле "Місто" обов\'язкове для заповнення.',
            'password' => 'Поле "Пароль" обов\'язкове для заповнення.',
            'email.required' => 'Поле "Електронна пошта" обов\'язкове для заповнення.',
            'email.email' => 'Невірний формат електронної пошти.',
            'email.unique' => 'Ця електронна пошта вже використовується.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'city' => $this->city,
            'password' => Hash::make($this->password),
            'politic_success' => true,
        ]);

        Auth::login($user);

        event(new SendRegisterEmailUser($user, $this->password));

        $this->redirect('/account');
    }

    public function render()
    {
        SEOMeta::setTitle('Реєстрація');
        SEOMeta::setDescription('Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.');
        return view('livewire.auth.register');
    }
}
