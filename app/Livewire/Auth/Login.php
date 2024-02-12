<?php

namespace App\Livewire\Auth;

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
        return view('livewire.auth.login');
    }
}
