<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;


class GoogleSheetController extends Controller
{
    public function addToSheet()
    {
        $data = [
            "Имя" => "Новое имя",
            "Фамилия" => "Новая фамилия",
            "Почта" => "example@example.com",
            "Телефон" => "1234567890",
            "Заказ" => "Новый заказ",
            "Стоимость" => "100",
            "Дата и время" => now()->format('Y-m-d H:i:s'),
        ];

        // ID вашей Google таблицы
        $spreadsheetId = '1-eU30QRhoPt-Y_A_5Gy5xaCkzkL5tU6Yxvr4VL9rLpw';

        // Название листа в таблице
        $sheetName = '2024';

        // Получение доступа к таблице
        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);

        // Добавление данных в таблицу
        $sheet->append([$data]);
    }
}
