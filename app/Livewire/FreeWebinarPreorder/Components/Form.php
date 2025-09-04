<?php

namespace App\Livewire\FreeWebinarPreorder\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Revolution\Google\Sheets\Facades\Sheets;

class Form extends Component
{
    public $webinar;     // массив данных вебинара (содержит form_id и т.п.)
    public $webinar_id;

    public $name;
    public $phone;
    public $email;
    public $city;
    public $endo;        // для совместимости со старым одноточечным вопросом (Эндодонтия)

    /**
     * Слушаем отправку с фронта.
     * Приходит payload вида: { formData: { name, phone, email, city, answers: [...], endodontics? } }
     */
    #[On('formSubmittedPreorder')]
    public function send($payload)
    {
        // поддержка двух форматов: {formData:{...}} и просто {...}
        $formData = $payload['formData'] ?? $payload;

        $this->name  = (string)($formData['name']  ?? '');
        $this->phone = (string)($formData['phone'] ?? '');
        $this->email = (string)($formData['email'] ?? '');
        $this->city  = (string)($formData['city']  ?? '');

        // базовая валидация
        $this->validate([
            'name'  => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|string', // был required, но часто email опционален
            'city'  => 'nullable|string',
        ]);

        // --- Динамические ответы ---
        $answers = is_array($formData['answers'] ?? null) ? $formData['answers'] : [];

        // Сформируем ассоциативный массив: 'Текст вопроса' => 'Ответ'
        $answersAssoc = [];
        foreach ($answers as $idx => $row) {
            if (!is_array($row)) {
                continue;
            }
            $question = trim((string)($row['question'] ?? ''));
            $type     = (string)($row['type'] ?? 'select');
            $raw      = $row['value'] ?? null;

            // Значение в человекочитаемом виде
            if ($type === 'select') {
                // фронт шлёт yes/no → кладём Да/Нет
                $value = $raw === 'yes' ? 'Да' : ($raw === 'no' ? 'Нет' : (string)$raw);
            } else {
                $value = trim((string)$raw);
            }

            // Ключ-колонка: текст вопроса или fallback
            $key = $question !== '' ? $question : ('Вопрос ' . ($idx + 1));
            $answersAssoc[$key] = $value;
        }

        // --- Совместимость со старым endodontics (если был один radio-вопрос)
        $this->endo = null;
        if (array_key_exists('endodontics', $formData)) {
            $this->endo = $formData['endodontics'] === 'yes' ? 'Да' : 'Нет';
        } else {
            // Или если среди вопросов есть что-то про эндо — вынесем отдельно в колонку "Эндодонтия"
            foreach ($answersAssoc as $q => $v) {
                $qLower = mb_strtolower($q, 'UTF-8');
                if (str_contains($qLower, 'эндодонт') || str_contains($qLower, 'ендодонт')) {
                    $this->endo = (string)$v;
                    break;
                }
            }
        }

        // Запись в Google Sheets (базовые + динамические)
        $this->addToSheet($answersAssoc);

        // уведомление во фронт
        $this->dispatch('notify', title: 'Дякуємо за реєстрацію! Лист на трансляцію надійде за 1 день до початку вебінару.');

        // при необходимости — отправка письма
        // Mail::to($this->email)->send(new MessagePreorderWebinarFree($this->webinar_id));
    }

    /**
     * Добавляем строку в Google Sheet.
     * $answersAssoc: ['Текст вопроса' => 'Ответ', ...]
     */
    public function addToSheet(array $answersAssoc = [])
    {
        // Базовые поля
        $data = [
            'Имя'          => $this->name,
            'Телефон'      => $this->phone,
            'Email'        => $this->email,
            'Город'        => $this->city,
            'Дата и время' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // Если удалось выделить "Эндодонтия" — добавим отдельной колонкой (совместимость)
        if ($this->endo !== null) {
            $data['Эндодонтия'] = $this->endo;
        }

        // Динамические вопросы → отдельные колонки с именем по тексту вопроса
        foreach ($answersAssoc as $question => $value) {
            // если вдруг значение не строка — сериализуем
            $data[$question] = is_scalar($value)
                ? (string)$value
                : json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        // Важно: ваш Google Sheet должен иметь заголовки (первую строку) с такими названиями колонок.
        // Если каких-то колонок нет — добавьте их в шапке таблицы.
        $spreadsheetId = $this->webinar['form_id'];
        $sheetName     = 'Лист1';

        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);

        // Библиотека обычно ждёт массив массива значений; однако многие используют ассоциативные
        // массивы с маппингом по заголовкам. Оставляю как у вас было:
        $sheet->append([$data]);
    }

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.form');
    }
}
