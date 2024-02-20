<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;

class Reset extends Component
{
    public $token;
    public $password;

    public function updatePassword()
    {
        $user = User::where('remember_token', $this->token)->first();
        if ($user) {
            $user->password = Hash::make($this->password);
            $user->remember_token = Str::random(40);
            $user->save();
            Session::flash('success', 'Ваш пароль було оновлено');
            $this->redirect('/login');
        } else {
            abort(404);
        }
    }

    public function mount($token)
    {
       $user = User::where('remember_token', $token)->first();
       if (!$user) {
           abort(404);
       }
    }

    public function render()
    {
        SEOMeta::setTitle('Відновлення паролю');
        SEOMeta::setDescription('Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.');
        return view('livewire.auth.reset');
    }
}
