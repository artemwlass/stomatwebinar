<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>Результат теста</title>
    <style>
        @page {
            margin: 28px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #172033;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.45;
            background: #ffffff;
        }

        .header {
            padding-bottom: 16px;
            border-bottom: 2px solid #0b3fa4;
            margin-bottom: 18px;
        }

        .eyebrow {
            color: #0b3fa4;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        h1 {
            margin: 4px 0 0;
            color: #0b3fa4;
            font-size: 24px;
            line-height: 1.2;
        }

        .meta {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: collapse;
        }

        .meta td {
            width: 50%;
            padding: 7px 10px;
            border: 1px solid #d9e2f2;
            vertical-align: top;
        }

        .label {
            display: block;
            color: #617089;
            font-size: 10px;
            text-transform: uppercase;
        }

        .value {
            display: block;
            margin-top: 2px;
            color: #172033;
            font-size: 12px;
            font-weight: bold;
        }

        .score {
            color: #0b3fa4;
            font-size: 16px;
        }

        table.answers {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .answers th {
            padding: 8px 7px;
            border: 1px solid #0b3fa4;
            color: #ffffff;
            background: #0b3fa4;
            font-size: 10px;
            text-align: left;
            text-transform: uppercase;
        }

        .answers td {
            padding: 8px 7px;
            border: 1px solid #d9e2f2;
            vertical-align: top;
            word-wrap: break-word;
        }

        .answers tr:nth-child(even) td {
            background: #f7faff;
        }

        .col-number {
            width: 36px;
            text-align: center;
        }

        .col-question {
            width: 34%;
        }

        .col-answer {
            width: 24%;
        }

        .col-result {
            width: 72px;
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 10px;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-ok {
            background: #15803d;
        }

        .badge-error {
            background: #b91c1c;
        }

        .badge-empty {
            background: #64748b;
        }

        .footer {
            margin-top: 16px;
            color: #617089;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="eyebrow">Stomat Webinar</div>
        <h1>Результат теста</h1>
    </div>

    <table class="meta">
        <tr>
            <td>
                <span class="label">Вебинар</span>
                <span class="value">{{ $meta['webinar'] }}</span>
            </td>
            <td>
                <span class="label">Баллы</span>
                <span class="value score">{{ $meta['score'] }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">ФИО</span>
                <span class="value">{{ $meta['full_name'] }}</span>
            </td>
            <td>
                <span class="label">Почта</span>
                <span class="value">{{ $meta['email'] }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Страна</span>
                <span class="value">{{ $meta['country'] }}</span>
            </td>
            <td>
                <span class="label">Дата прохождения</span>
                <span class="value">{{ $meta['submitted_at'] }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Место работы</span>
                <span class="value">{{ $meta['work_place'] }}</span>
            </td>
            <td>
                <span class="label">Должность</span>
                <span class="value">{{ $meta['position'] }}</span>
            </td>
        </tr>
    </table>

    <table class="answers">
        <thead>
            <tr>
                <th class="col-number">№</th>
                <th class="col-question">Вопрос</th>
                <th class="col-answer">Ответ пользователя</th>
                <th class="col-answer">Правильный ответ</th>
                <th class="col-result">Итог</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td class="col-number">{{ $row['number'] }}</td>
                    <td>{{ $row['question'] }}</td>
                    <td>{{ $row['user_answer'] }}</td>
                    <td>{{ $row['correct_answer'] }}</td>
                    <td class="col-result">
                        @if ($row['is_correct'] === true)
                            <span class="badge badge-ok">Верно</span>
                        @elseif ($row['is_correct'] === false)
                            <span class="badge badge-error">Неверно</span>
                        @else
                            <span class="badge badge-empty">—</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Сформировано: {{ now()->format('d.m.Y H:i') }}
    </div>
</body>
</html>
