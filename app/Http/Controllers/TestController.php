<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $receivedData = $request->input('data');
        $receivedSignature = $request->input('signature');

// Декодирование данных из Base64
        $decodedData = base64_decode($receivedData);

// Генерация подписи для проверки
        $generatedSignature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $decodedData . env('LIQPAY_PRIVATE_KEY'), true));

// Проверка подписи
        if ($generatedSignature === $receivedSignature) {
            // Подписи совпадают, обрабатываем данные
            $jsonData = json_decode($decodedData, true); // Преобразование JSON в массив
            Log::debug($jsonData);

            // Действия в зависимости от данных о транзакции
            // Например, проверка статуса платежа
            if ($jsonData['status'] === 'success') {
                Log::debug('true');
            } else {
                Log::debug('false');
            }
        } else {
            Log::debug('false2');
        }

    }
}
