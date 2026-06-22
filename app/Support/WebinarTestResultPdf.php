<?php

namespace App\Support;

use App\Models\WebinarTestResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;
use Illuminate\Support\Collection;

class WebinarTestResultPdf
{
    public static function make(WebinarTestResult $result): DomPdf
    {
        $result->loadMissing(['user', 'webinar']);

        return Pdf::loadView('pdf.webinar-test-result', [
            'meta' => self::meta($result),
            'rows' => self::rows($result),
        ])->setPaper('a4');
    }

    private static function meta(WebinarTestResult $result): array
    {
        return [
            'webinar' => self::safeText($result->webinar?->title ?: '—'),
            'full_name' => self::safeText(CertificatePresenter::fullName($result) ?: '—'),
            'email' => self::safeText($result->user?->email ?: '—'),
            'country' => self::safeText($result->user?->country ?: '—'),
            'work_place' => self::safeText($result->user?->work_place ?: '—'),
            'position' => self::safeText($result->user?->position ?: '—'),
            'score' => self::safeText(self::score($result)),
            'submitted_at' => self::safeText(
                ($result->passed_at ?? $result->updated_at)
                    ? ($result->passed_at ?? $result->updated_at)->copy()->timezone(config('app.display_timezone'))->format('d.m.Y H:i')
                    : '—'
            ),
        ];
    }

    public static function score(WebinarTestResult $result): string
    {
        $tests = self::testQuestions($result);
        $totalQuestions = $tests->count();

        if ($totalQuestions === 0) {
            return $result->score_percent !== null ? ((int) $result->score_percent) . '%' : '—';
        }

        $answers = $result->answers ?? [];
        $correctAnswers = $tests->reduce(function (int $carry, array $test, int $index) use ($answers): int {
            return $carry + ((string) ($answers[$index] ?? '') === (string) ($test['correct_answer'] ?? '') ? 1 : 0);
        }, 0);

        return $correctAnswers . '/' . $totalQuestions;
    }

    private static function rows(WebinarTestResult $result): array
    {
        $tests = self::testQuestions($result);
        $answers = $result->answers ?? [];

        if ($tests->isEmpty()) {
            return [[
                'number' => '—',
                'question' => 'Питання не знайдено',
                'user_answer' => self::safeJson($answers),
                'correct_answer' => '—',
                'is_correct' => null,
            ]];
        }

        return $tests
            ->map(function (array $test, int $index) use ($answers): array {
                $userAnswerIndex = (string) ($answers[$index] ?? '');
                $correctAnswerIndex = (string) ($test['correct_answer'] ?? '');

                return [
                    'number' => $index + 1,
                    'question' => self::safeText($test['question'] ?? ''),
                    'user_answer' => self::answerText($test, $userAnswerIndex),
                    'correct_answer' => self::answerText($test, $correctAnswerIndex),
                    'is_correct' => $userAnswerIndex === $correctAnswerIndex,
                ];
            })
            ->all();
    }

    private static function answerText(array $test, string $answerIndex): string
    {
        if ($answerIndex === '') {
            return '—';
        }

        $answer = $test['answers'][(int) $answerIndex]['text'] ?? null;

        return filled($answer) ? self::safeText($answer) : '—';
    }

    private static function testQuestions(WebinarTestResult $result): Collection
    {
        return collect($result->webinar?->tests ?? [])
            ->filter(fn ($test) => ! empty($test['question']) && ! empty($test['answers']) && is_array($test['answers']))
            ->values();
    }

    private static function safeJson(mixed $value): string
    {
        return json_encode(
            $value,
            JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE | JSON_PARTIAL_OUTPUT_ON_ERROR
        ) ?: '—';
    }

    private static function safeText(mixed $value): string
    {
        $text = (string) $value;

        if (function_exists('mb_scrub')) {
            return mb_scrub($text, 'UTF-8');
        }

        if (function_exists('mb_check_encoding') && mb_check_encoding($text, 'UTF-8')) {
            return $text;
        }

        $converted = iconv('UTF-8', 'UTF-8//IGNORE', $text);

        return $converted === false ? '' : $converted;
    }
}
