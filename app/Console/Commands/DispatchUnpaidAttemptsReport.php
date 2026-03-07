<?php

namespace App\Console\Commands;

use App\Models\PaymentAttempt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class DispatchUnpaidAttemptsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unpaid:dispatch-report
                            {--limit=500 : Max attempts per run}
                            {--chat-id=-5108233408 : Telegram chat id}
                            {--sheet=Не оплачено : Google Sheet tab name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send unpaid payment attempts to Google Sheet and Telegram in one command without duplicates';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = max((int) $this->option('limit'), 1);
        $chatId = (string) $this->option('chat-id');
        $sheetName = (string) $this->option('sheet');
        $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID', '1-eU30QRhoPt-Y_A_5Gy5xaCkzkL5tU6Yxvr4VL9rLpw');
        $botToken = env('TOKEN_TELEGRAM');

        if (blank($botToken)) {
            $this->warn('TOKEN_TELEGRAM is empty, Telegram dispatch will be skipped.');
        }

        $attempts = PaymentAttempt::query()
            ->whereIn('status', ['pending', 'failed'])
            ->where(function ($query) {
                $query->whereNull('unpaid_sheet_synced_at')
                    ->orWhereNull('unpaid_telegram_sent_at');
            })
            ->orderBy('id')
            ->limit($limit)
            ->get();

        if ($attempts->isEmpty()) {
            $this->info('No unpaid attempts to dispatch.');
            return self::SUCCESS;
        }

        $sheet = Sheets::spreadsheet($spreadsheetId)->sheet($sheetName);

        $sheetSynced = 0;
        $telegramSent = 0;

        foreach ($attempts as $attempt) {
            $cartItems = is_array($attempt->cart_data) ? $attempt->cart_data : [];
            $webinarNames = collect($cartItems)->pluck('name')->filter()->implode(', ');
            $attribution = is_array($attempt->attribution_data) ? $attempt->attribution_data : [];

            if (is_null($attempt->unpaid_sheet_synced_at)) {
                try {
                    $row = [
                        trim(($attempt->user_name ?? '') . ' ' . ($attempt->user_surname ?? '')),
                        optional($attempt->created_at)->format('Y-m-d H:i:s'),
                        $attempt->user_email,
                        $attempt->user_phone,
                        $attempt->status,
                        $attempt->amount,
                        $webinarNames,
                    ];

                    $sheet->append([$row]);
                    $attempt->unpaid_sheet_synced_at = now();
                    $sheetSynced++;
                } catch (\Throwable $e) {
                    Log::error('Failed to sync unpaid attempt to sheet', [
                        'payment_attempt_id' => $attempt->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            if (is_null($attempt->unpaid_telegram_sent_at) && filled($botToken)) {
                try {
                    $text = implode("\n", [
                        'Неоплата',
                        'ID попытки: ' . $attempt->id,
                        'Статус: ' . $attempt->status,
                        'ФИО: ' . trim(($attempt->user_name ?? '') . ' ' . ($attempt->user_surname ?? '')),
                        'Почта: ' . ($attempt->user_email ?? '-'),
                        'Телефон: ' . ($attempt->user_phone ?? '-'),
                        'Сумма: ' . ($attempt->amount ?? '-') . ' ' . ($attempt->currency ?? 'UAH'),
                        'Вебинары: ' . ($webinarNames ?: '-'),
                        'Дата попытки: ' . optional($attempt->created_at)->format('Y-m-d H:i:s'),
                        'Ссылка перехода: ' . ($attribution['landing_url'] ?? '-'),
                    ]);

                    $response = Http::post(
                        'https://api.telegram.org/bot' . $botToken . '/sendMessage',
                        [
                            'chat_id' => $chatId,
                            'text' => $text,
                        ]
                    );

                    if ($response->successful()) {
                        $attempt->unpaid_telegram_sent_at = now();
                        $telegramSent++;
                    } else {
                        $this->warn(
                            "Telegram failed for attempt #{$attempt->id}: HTTP {$response->status()} {$response->body()}"
                        );
                        Log::error('Failed to send unpaid attempt to telegram', [
                            'payment_attempt_id' => $attempt->id,
                            'status' => $response->status(),
                            'response' => $response->body(),
                        ]);
                    }
                } catch (\Throwable $e) {
                    $this->warn("Telegram exception for attempt #{$attempt->id}: {$e->getMessage()}");
                    Log::error('Telegram exception while sending unpaid attempt', [
                        'payment_attempt_id' => $attempt->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            if ($attempt->isDirty()) {
                $attempt->save();
            }
        }

        $this->info("Sheet synced: {$sheetSynced}");
        $this->info("Telegram sent: {$telegramSent}");

        return self::SUCCESS;
    }
}
