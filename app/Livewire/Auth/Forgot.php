<?php

namespace App\Livewire\Auth;

use App\Events\SendRegisterEmailUser;
use App\Mail\ForgotPassword;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;

class Forgot extends Component
{
    public $email;

    public function sendInstruction()
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $user->remember_token = Str::random(40);
            $user->save();
            try {
                Mail::to($user->email)->send(new ForgotPassword($user));
            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                Log::error("Ошибка отправки почты: " . $e->getMessage());
            }
            Session::flash('success', 'Ми вислали вам інструкцію для відновлення пароля на пошту');
            $this->email = '';
        } else {
            Session::flash('error', 'Користувача не знайдено');
        }
    }
    public function render()
    {
        SEOMeta::setTitle('Відновлення паролю');
        SEOMeta::setDescription('Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.');
        return view('livewire.auth.forgot');
    }
}
