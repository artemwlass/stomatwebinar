<?php

namespace App\Livewire\Components;

use App\Events\SendEmail;
use App\Events\SendTelegram;
use Livewire\Attributes\On;
use Livewire\Component;

class SupportCall extends Component
{
    public $name, $phone, $email;

    #[On('formSubmitted2')]
    public function send($formData)
    {
        $this->name = $formData['name'];
        $this->phone = $formData['phone'];
        $this->email = $formData['email'];
        // Валидация входных данных
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $support = \App\Models\Support::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'text' => 'Заказ звонка',
        ]);

        event(new SendTelegram($support));
        event(new SendEmail($support));

        $this->reset('name', 'phone', 'email');
    }

    public function render()
    {
        return view('livewire.components.support-call');
    }
}
