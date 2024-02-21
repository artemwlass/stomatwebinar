<?php

namespace App\Livewire\Components;

use App\Events\SendEmail;
use App\Events\SendTelegram;
use App\Models\SupportWidget;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Support extends Component
{

    public $name;
    public $phone;
    public $email;
    public $text;

    #[On('formSubmitted')]
    public function send($formData)
    {
        $this->name = $formData['name'];
        $this->phone = $formData['phone'];
        $this->email = $formData['email'];
        $this->text = $formData['text'];
        // Валидация входных данных
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'text' => 'required|string',
        ]);

        $support = \App\Models\Support::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'text' => $this->text,
        ]);

        event(new SendTelegram($support));

        try {
            event(new SendEmail($support));
        } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
            Log::error("Ошибка отправки почты: " . $e->getMessage());
        }


        $this->reset('name', 'phone', 'email', 'text');
    }

    public function render()
    {
        $support = SupportWidget::first();
        return view('livewire.components.support', compact('support'));
    }
}
