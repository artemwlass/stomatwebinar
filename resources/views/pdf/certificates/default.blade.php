<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>{{ $fileName }}</title>
    <style>
        @page {
            size: 1200pt 675pt;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 1200pt;
            height: 675pt;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: DejaVu Sans, sans-serif;
            color: #000;
        }

        .certificate {
            position: relative;
            width: 1200pt;
            height: 675pt;
            overflow: hidden;
            page-break-after: avoid;
            page-break-before: avoid;
            page-break-inside: avoid;
        }

        .certificate-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 1200pt;
            height: 675pt;
        }

        .issuer {
            position: absolute;
            top: 75pt;
            left: 0;
            width: 1200pt;
            text-align: center;
            font-size: 20pt;
            line-height: 1;
        }

        .title {
            position: absolute;
            top: 112pt;
            left: 0;
            width: 1200pt;
            text-align: center;
            color: #163a99;
            font-family: DejaVu Serif, DejaVu Sans, serif;
            font-size: 80pt;
            line-height: 1;
            letter-spacing: 9pt;
            font-weight: normal;
        }

        .line-title {
            position: absolute;
            top: 201pt;
            left: 320pt;
            width: 581pt;
            height: 9pt;
        }

        .number {
            position: absolute;
            top: 229pt;
            left: 0;
            width: 1200pt;
            text-align: center;
            font-size: 19.5pt;
            line-height: 1;
            font-style: italic;
        }

        .person {
            position: absolute;
            top: 265pt;
            left: 180pt;
            width: 840pt;
            text-align: center;
            color: #173ba3;
            font-size: 38pt;
            line-height: 1;
            font-style: italic;
            font-weight: bold;
        }

        .line-person {
            position: absolute;
            top: 307pt;
            left: 342pt;
            width: 541pt;
            height: 4pt;
        }

        .kind {
            position: absolute;
            top: 324pt;
            left: 0;
            width: 1200pt;
            text-align: center;
            font-size: 17pt;
            line-height: 1;
        }

        .course {
            position: absolute;
            top: 354pt;
            left: 150pt;
            width: 900pt;
            text-align: center;
            font-size: 22pt;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .format {
            position: absolute;
            top: 392pt;
            left: 0;
            width: 1200pt;
            text-align: center;
            font-size: 17pt;
            line-height: 1;
            font-style: italic;
        }

        .specialty-title {
            position: absolute;
            top: 440pt;
            left: 95pt;
            width: 720pt;
            color: #163a99;
            font-size: 16pt;
            line-height: 1;
            font-weight: bold;
        }

        .specialty {
            position: absolute;
            top: 459pt;
            left: 95pt;
            width: 760pt;
            font-size: 15pt;
            line-height: 1.15;
            font-style: italic;
        }

        .date {
            position: absolute;
            top: 516pt;
            left: 95pt;
            font-size: 16pt;
            line-height: 1;
        }

        .date b {
            color: #163a99;
        }

        .signature {
            position: absolute;
            left: 105pt;
            top: 556pt;
            width: 102pt;
            height: 43.5pt;
        }

        .seal {
            position: absolute;
            top: 530pt;
            left: 214pt;
            width: 71pt;
            height: 69pt;
        }

        .director {
            position: absolute;
            left: 95pt;
            top: 607pt;
            font-size: 12pt;
            line-height: 1;
        }

        .points {
            position: absolute;
            top: 568pt;
            left: 375pt;
            width: 470pt;
            text-align: center;
            color: #173ba3;
            font-size: 34pt;
            line-height: 1;
            font-style: italic;
            font-weight: bold;
        }

        .line-points {
            position: absolute;
            top: 608pt;
            left: 376pt;
            width: 469pt;
            height: 4pt;
        }

        .issued {
            position: absolute;
            right: 95pt;
            top: 599pt;
            font-size: 19.5pt;
            line-height: 1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <main class="certificate" aria-label="Сертифікат">
        <img src="{{ public_path('certificate/images/bg-img.png') }}" alt="" class="certificate-bg">

        <div class="issuer">{{ $providerName }}</div>
        <div class="title">СЕРТИФІКАТ</div>
        <img src="{{ public_path('certificate/images/line-1.png') }}" alt="" class="line-title">

        <div class="number">№ {{ $certificateNumber }}</div>
        <div class="person">{{ $fullName ?: 'Прізвище Ім’я По батькові' }}</div>
        <img src="{{ public_path('certificate/images/line-2.png') }}" alt="" class="line-person">

        <div class="kind">майстер-клас</div>
        <div class="course">«{{ $courseTitle }}»</div>
        <div class="format">дистанційна участь</div>

        <div class="specialty-title">Спеціальності, за якими проводилось навчання:</div>
        <div class="specialty">{{ $specialty }}</div>

        <div class="date"><b>Дата:</b> {{ $issuedAt }}</div>

        <img src="{{ public_path('certificate/images/signature.png') }}" alt="" class="signature">
        <img src="{{ public_path('certificate/images/seal.png') }}" alt="" class="seal">
        <div class="director">Директор Тищенко Марина Юріївна</div>

        <div class="points">2 години@if ($result->webinar->bpr_points), {{ $result->webinar->bpr_points }} балів БПР@endif</div>
        <img src="{{ public_path('certificate/images/line-3.png') }}" alt="" class="line-points">

        <div class="issued">Видано: {{ $issuedNextDayAt }}</div>
    </main>
</body>
</html>
