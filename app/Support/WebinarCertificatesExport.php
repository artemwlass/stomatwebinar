<?php

namespace App\Support;

use App\Models\Webinar;
use App\Models\WebinarTestResult;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WebinarCertificatesExport
{
    public static function download(Webinar $webinar): StreamedResponse
    {
        $fileName = 'webinar-' . $webinar->id . '-certificates.xlsx';

        return response()->streamDownload(function () use ($webinar): void {
            $spreadsheet = self::build($webinar);
            (new Xlsx($spreadsheet))->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private static function build(Webinar $webinar): Spreadsheet
    {
        $webinar->loadMissing(['testResults.user']);

        $questions = self::questions($webinar);
        $headers = [
            'Позначка часу',
            'Результат',
            'ПІБ (повністю, українською мовою):',
            'Ваша електронна пошта:',
            'Ваш телефон',
            'Ваша дата народження:',
            'Ваше місце роботи (місто, назва установи):',
            'Ваша посада (напр., лікар-стоматолог)',
            'Ваше Місто',
            'Ваша спеціальність:',
            ...$questions->pluck('question')->map(fn ($question) => self::safeText($question))->all(),
            'Сертифікат',
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Сертифікати');
        $sheet->fromArray($headers, null, 'A1');

        $results = WebinarTestResult::query()
            ->with(['user', 'webinar'])
            ->where('webinar_id', $webinar->id)
            ->where('is_passed', true)
            ->whereNotNull('certificate_number')
            ->oldest('passed_at')
            ->get();

        $row = 2;

        foreach ($results as $result) {
            $user = $result->user;
            $answers = $result->answers ?? [];
            $answerValues = $questions
                ->map(fn (array $question, int $index): string => self::answerText($question, (string) ($answers[$index] ?? '')))
                ->all();

            $sheet->fromArray([
                self::safeText(($result->passed_at ?? $result->updated_at)?->copy()->timezone(config('app.display_timezone'))->format('d.m.Y H:i') ?: ''),
                self::safeText(WebinarTestResultPdf::score($result)),
                self::safeText(CertificatePresenter::fullName($result)),
                self::safeText($user?->email),
                self::safeText($user?->phone),
                self::safeText(optional($user?->birthday)->format('d.m.Y')),
                self::safeText($user?->work_place),
                self::safeText($user?->position),
                self::safeText($user?->city),
                self::safeText($user?->specialty),
                ...$answerValues,
                self::safeText(CertificatePresenter::number($result)),
            ], null, 'A' . $row);

            $row++;
        }

        self::style($sheet, count($headers), max(1, $row - 1));

        return $spreadsheet;
    }

    private static function style($sheet, int $columnCount, int $lastRow): void
    {
        $lastColumn = Coordinate::stringFromColumnIndex($columnCount);
        $fullRange = 'A1:' . $lastColumn . $lastRow;
        $headerRange = 'A1:' . $lastColumn . '1';

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '6D28D9'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        $sheet->getStyle('C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '0F172A'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A7F3D0'],
            ],
        ]);

        $sheet->getStyle($fullRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D8DEE9'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
        ]);

        $sheet->freezePane('A2');
        $sheet->setAutoFilter($fullRange);
        $sheet->getRowDimension(1)->setRowHeight(42);

        $widths = [
            'A' => 18,
            'B' => 12,
            'C' => 34,
            'D' => 30,
            'E' => 18,
            'F' => 18,
            'G' => 34,
            'H' => 30,
            'I' => 20,
            'J' => 24,
        ];

        foreach ($widths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        for ($index = 11; $index <= $columnCount; $index++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($index))->setWidth($index === $columnCount ? 28 : 36);
        }
    }

    private static function questions(Webinar $webinar): Collection
    {
        return collect($webinar->tests ?? [])
            ->filter(fn ($test) => ! empty($test['question']) && ! empty($test['answers']) && is_array($test['answers']))
            ->values();
    }

    private static function answerText(array $question, string $answerIndex): string
    {
        if ($answerIndex === '') {
            return '';
        }

        return self::safeText($question['answers'][(int) $answerIndex]['text'] ?? '');
    }

    private static function safeText(mixed $value): string
    {
        $text = (string) ($value ?? '');

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
