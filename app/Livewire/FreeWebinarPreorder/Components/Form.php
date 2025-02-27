<?php

namespace App\Livewire\FreeWebinarPreorder\Components;

use App\Mail\MessagePreorderWebinarFree;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Revolution\Google\Sheets\Facades\Sheets;

class Form extends Component
{
    public $webinar;
    public $webinar_id;

    public $name;
    public $phone;
    public $email;
    public $city;
    public $endo;

    #[On('formSubmittedPreorder')]
    public function send($formData)
    {
        $this->name = $formData['name'];
        $this->phone = $formData['phone'];
        $this->email = $formData['email'];
        $this->city = $formData['city'];

        if ($formData['endodontics'] == 'yes')
        {
            $this->endo = 'Да';
        } else {
            $this->endo = 'Нет';
        }
        // Валидация входных данных
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'city' => 'required|string',
        ]);

        $this->addToSheet();

        $this->dispatch('notify', title: 'Дякуємо за реєстрацію! Лист на трансляцію надійде за 1 день початку вебінару.');

//        Mail::to($this->email)->send(new MessagePreorderWebinarFree($this->webinar_id));
    }

    public function addToSheet()
    {
        $data = [
            "Имя" => $this->name,
            "Телефон" => $this->email,
            "Email" => $this->phone,
            "Город" => $this->city,
            "Эндодонтия" => $this->endo,
            "Дата и время" => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // ID вашей Google таблицы
        $spreadsheetId = $this->webinar['form_id'];

        // Название листа в таблице
        $sheetName = 'Лист1';

        // Получение доступа к таблице
        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);

        // Добавление данных в таблицу
        $sheet->append([$data]);
    }

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.form');
    }
}
