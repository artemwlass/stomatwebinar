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
    public function send($formData = []): void
    {
        // Поддержка вызова как send({formData:{...}}) и как send({...})
        $data = is_array($formData) && array_key_exists('formData', $formData)
            ? (array) $formData['formData']
            : (array) $formData;

        // Базовые поля
        $this->name  = (string)($data['name']  ?? '');
        $this->phone = (string)($data['phone'] ?? '');
        $this->email = (string)($data['email'] ?? '');
        $this->city  = (string)($data['city']  ?? '');

        // Совместимость со старым одиночным полем
        if (array_key_exists('endodontics', $data)) {
            $this->endo = $data['endodontics'] === 'yes'
                ? 'Да'
                : ($data['endodontics'] === 'no' ? 'Нет' : null);
        } else {
            $this->endo = null;
        }

        // Валидация (оставляем только то, что реально требуется)
        $this->validate([
            'name'  => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'city'  => 'nullable|string',
        ]);

        // Преобразуем новые "рандомные" вопросы (если есть)
        $answersAssoc = [];
        if (!empty($data['answers']) && is_array($data['answers'])) {
            foreach ($data['answers'] as $i => $row) {
                if (!is_array($row)) continue;

                $qText = trim((string)($row['question'] ?? 'Вопрос ' . ($i + 1)));
                $type  = (string)($row['type'] ?? 'select');
                $val   = $row['value'] ?? null;

                // для select маппим yes/no → Да/Нет
                if ($type === 'select') {
                    $answersAssoc[$qText] = $val === 'yes' ? 'Да' : ($val === 'no' ? 'Нет' : (string)$val);
                } else {
                    $answersAssoc[$qText] = trim((string)$val);
                }
            }

            // Если старое поле не передали, но есть ровно один select — продублируем в $this->endo
            if ($this->endo === null) {
                $selects = array_filter($data['answers'], fn ($r) => is_array($r) && (($r['type'] ?? 'select') === 'select'));
                if (count($selects) === 1) {
                    $only = array_values($selects)[0] ?? null;
                    if ($only) {
                        $this->endo = ($only['value'] ?? null) === 'yes' ? 'Да'
                            : ((($only['value'] ?? null) === 'no') ? 'Нет' : null);
                    }
                }
            }
        }

        // Запись в Google Sheets
        $this->addToSheet($answersAssoc);

        // Нотификация
        $this->dispatch('notify', title: 'Дякуємо за реєстрацію! Лист на трансляцію надійде за 1 день початку вебінару.');

        // Если понадобится — раскомментируй отправку письма
        // Mail::to($this->email)->send(new MessagePreorderWebinarFree($this->webinar_id));
    }

    public function addToSheet(array $extraAnswers = []): void
    {
        // Базовые поля — оставляю как у тебя было (в т.ч. порядок/ключи)
        $data = [
            "Имя"          => $this->name,
            "Телефон"      => $this->email, // как в исходнике
            "Email"        => $this->phone, // как в исходнике
            "Город"        => $this->city,
            "Эндодонтия"   => $this->endo,
            "Дата и время" => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // Добавляем ответы на динамические вопросы (ключ — текст вопроса)
        foreach ($extraAnswers as $q => $answer) {
            if ($q === '' || $answer === null) continue;
            $data[$q] = $answer;
        }

        // ID таблицы
        $spreadsheetId = $this->webinar['form_id'] ?? null;
        if (!$spreadsheetId) return;

        $sheetName = 'Лист1';

        // Запись
        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);
        $sheet->append([$data]);
    }

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.form');
    }
}
