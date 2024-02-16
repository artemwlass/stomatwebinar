<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResultPaymentController extends Controller
{
    public function index(Request $request)
    {
        $receivedData = $request->input('data');
        $receivedSignature = $request->input('signature');



// Генерация подписи для проверки
        $generatedSignature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $receivedData . env('LIQPAY_PRIVATE_KEY'), true));


// Проверка подписи
        if ($generatedSignature === $receivedSignature) {
            $jsonString = base64_decode($receivedData);
            $jsonData = json_decode($jsonString, true);
            Log::debug($jsonData);

        }

    }
}
