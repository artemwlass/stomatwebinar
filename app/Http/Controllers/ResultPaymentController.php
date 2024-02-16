<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $order = new Order;
            $order->user_id = Auth::id();
            $order->payment_id = $jsonData['payment_id'] ?? null;
            $order->transaction_id = $jsonData['transaction_id'] ?? null;
            $order->status = $jsonData['status'] ?? null;
            $order->paytype = $jsonData['paytype'] ?? null;
            $order->payment_created_at = now(); // Текущее время как время создания платежа
            $order->description = $jsonData['description'] ?? null;
            $order->save();

        }

    }
}
