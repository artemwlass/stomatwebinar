<?php

namespace App\Http\Controllers\Api;

use App\Events\SendEmailPreorder;
use App\Events\SendOrderEmail;
use App\Events\SendOrderTelegram;
use App\Http\Controllers\Controller;
use App\Models\GroupUser;
use App\Models\Order;
use App\Models\OrderWebinars;
use App\Models\User;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Revolution\Google\Sheets\Facades\Sheets;

class LiqPayController extends Controller
{
    public function process(Request $request)
    {
        Log::debug('LiqPay callback');
        Log::debug(json_encode($request->toArray()));

        if ($request->has('data') && $request->has('signature')) {
            $data = base64_decode($request->get('data'));
            $signature = base64_encode(
                sha1(env('LIQPAY_PRIVATE_KEY') . $request->get('data') . env('LIQPAY_PRIVATE_KEY'), 1)
            );

            if ($signature === $request->get('signature')) {
                Log::debug('LiqPay signature is valid');

                $data = json_decode($data, true);

                $cart = json_decode(base64_decode($data['dae']), true);

                if ($data['status'] != 'success') {
                    Log::debug('LiqPay status is not success');

                    return [
                        'status' => true,
                        'message' => 'failure'
                    ];
                }

                $timestampMilliseconds = $data['create_date'];
                $timestampSeconds = $timestampMilliseconds / 1000;

                $order = new Order;
                $order->user_id = $cart[0]['user_id'];
                $order->payment_id = $data['payment_id'] ?? null;
                $order->amount = $data['amount'] ?? null;
                $order->transaction_id = $data['transaction_id'] ?? null;
                $order->status = $data['status'] ?? null;
                $order->paytype = $data['paytype'] ?? null;
                $order->payment_created_at = Carbon::createFromTimestamp(
                    $timestampSeconds
                ); // Текущее время как время создания платежа
                $order->description = $data['description'] ?? null;
                $order->save();

                foreach ($cart as $value) {
                    if ($value['is_series'] == true) {
                        $series = Webinar::with('seriesWebinars.group')->find($value['id']);

                        OrderWebinars::create([
                            'order_id' => $order->id,
                            'user_id' => $value['user_id'],
                            'webinar_id' => $value['id'],
                            'price' => $value['price'],
                        ]);

                        if ($series) {
                            foreach ($series->seriesWebinars as $webinar) {
                                if ($webinar->group) {
                                    $groupId = $webinar->group->id;

                                    $existingGroupUser = GroupUser::where('group_id', $groupId)
                                        ->where('user_id', $value['user_id'])
                                        ->first();

                                    if (!$existingGroupUser) {
                                        GroupUser::create([
                                            'group_id' => $groupId,
                                            'user_id' => $value['user_id'],
                                            'closed_webinar_date' => now()->addDays(31)->format('Y-m-d')
                                        ]);
                                    }
                                }
                            }
                        }

                        try {
                            event(new SendOrderEmail($order));
                        } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                            Log::error("Ошибка отправки почты: " . $e->getMessage());
                        }
                    } else {
                        $groupId = $value['group_id'];
                        $userId = $value['user_id'];

                        $existingGroupUser = GroupUser::where('group_id', $groupId)
                            ->where('user_id', $userId)
                            ->first();

                        if (!$existingGroupUser) {
                            // Создание новой записи в group_users
                            GroupUser::create([
                                'group_id' => $groupId,
                                'user_id' => $userId,
                                'closed_webinar_date' => Carbon::now()->addDays(31)->format('Y-m-d')
                            ]);
                        }

                        $webinar = OrderWebinars::create([
                            'order_id' => $order->id,
                            'user_id' => $userId,
                            'webinar_id' => $value['id'],
                            'price' => $value['price'],
                        ]);

                        if ($value['is_preorder']) {
                            try {
                                event(new SendEmailPreorder($order, $webinar));
                            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                                Log::error("Ошибка отправки почты: " . $e->getMessage());
                            }
                        } else {
                            try {
                                event(new SendOrderEmail($order));
                            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                                Log::error("Ошибка отправки почты: " . $e->getMessage());
                            }
                        }
                    }
                }

                event(new SendOrderTelegram($order));

                Session::forget('payment_token');

                $this->addToSheet($cart[0]['user_id'], $order->description, $order->amount, $order->created_at);

                return [
                    'status' => true,
                    'message' => 'success'
                ];
            } else {
                Log::debug('LiqPay signature is invalid');
            }
        }

        return [
            'status' => false,
            'message' => 'Problem with payment',
        ];
    }

    public function addToSheet($userId, $description, $amount, $createdAd)
    {
        $user = User::find($userId);
        $data = [
            "Имя" => $user->name,
            "Фамилия" => $user->surname,
            "Почта" => $user->email,
            "Телефон" => $user->phone,
            "Заказ" => $description,
            "Стоимость" => $amount,
            "Дата и время" => Carbon::parse($createdAd)->format('Y-m-d H:i:s'),
        ];

        $spreadsheetId = '1-eU30QRhoPt-Y_A_5Gy5xaCkzkL5tU6Yxvr4VL9rLpw';
        $sheetName = '2024';
        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);

        $sheet->append([$data]);
    }
}
