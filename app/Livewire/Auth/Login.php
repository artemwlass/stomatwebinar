<?php

namespace App\Livewire\Auth;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->redirect('/account');
        } else {
            session()->flash('error', 'На жаль, ви ввели невірний пароль або електронну пошту. Повторіть спробу або натисніть "Забули пароль" для скидання.');
        }
    }
    public function render()
    {
        SEOMeta::setTitle('Авторизація');
        SEOMeta::setDescription('Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.');
        return view('livewire.auth.login');
    }
}
