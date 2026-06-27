<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>{{ $fileName }}</title>
    <style>
        @page {
            size: 841.89pt 595.28pt;
            margin: 0;
        }

        * { box-sizing: border-box; }

        html,
        body {
            width: 841.89pt;
            height: 595.28pt;
            margin: 0;
            padding: 0;
            overflow: hidden;
            color: #1c1c1c;
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
        }

        .page {
            position: relative;
            width: 841.89pt;
            height: 595.28pt;
            overflow: hidden;
            page-break-after: avoid;
            page-break-before: avoid;
            page-break-inside: avoid;
            background: #fff url("{{ public_path('cert_html/assets/bg.jpg') }}") center / 841.89pt 595.28pt no-repeat;
        }

        .certificate {
            position: absolute;
            inset: 0;
            width: 841.89pt;
            height: 595.28pt;
            overflow: hidden;
        }

        .frame {
            position: absolute;
            top: 27.75pt;
            right: 28.5pt;
            bottom: 27.75pt;
            left: 28.5pt;
            border: 1.5pt solid #0b3fa4;
        }

        .issuer {
            position: absolute;
            top: 62.25pt;
            left: 0;
            width: 100%;
            text-align: center;
            font-family: DejaVu Sans, sans-serif;
            font-size: 15pt;
            font-weight: normal;
            letter-spacing: 0;
        }

        h1 {
            position: absolute;
            top: 88.5pt;
            left: 0;
            width: 100%;
            margin: 0;
            text-align: center;
            color: #0b3fa4;
            font-family: DejaVu Serif, serif;
            font-size: 58.5pt;
            line-height: 1;
            font-weight: normal;
            letter-spacing: 6pt;
        }

        .title-line {
            position: absolute;
            top: 173.25pt;
            left: 217.5pt;
            width: 407.25pt;
            height: 1.5pt;
            background: #0b3fa4;
        }

        .number {
            position: absolute;
            top: 193.5pt;
            left: 0;
            width: 100%;
            text-align: center;
            font-style: italic;
            font-size: 14.25pt;
            letter-spacing: .75pt;
        }

        .person {
            position: absolute;
            top: 227.25pt;
            left: 97.5pt;
            right: 97.5pt;
            text-align: center;
            color: #0b3fa4;
            font-size: 27.75pt;
            line-height: 1.15;
            font-style: italic;
            font-weight: bold;
        }

        .person-line {
            position: absolute;
            top: 264pt;
            left: 217.5pt;
            width: 407.25pt;
            height: 1.5pt;
            background: #0b3fa4;
        }

        .kind,
        .event,
        .format {
            position: absolute;
            left: 75pt;
            right: 75pt;
            text-align: center;
        }

        .kind {
            top: 280.5pt;
            font-size: 15pt;
        }

        .event {
            top: 305.25pt;
            color: #1c1c1c;
            font-size: 17.25pt;
            line-height: 1.2;
            letter-spacing: .75pt;
            text-transform: uppercase;
        }

        .format {
            top: 343.5pt;
            font-size: 14.25pt;
            font-style: italic;
        }

        .specialties {
            position: absolute;
            top: 381.75pt;
            left: 63.75pt;
            width: 487.5pt;
            font-size: 11.25pt;
            line-height: 1.35;
        }

        .specialties strong {
            color: #0b3fa4;
            font-weight: bold;
        }

        .specialties em {
            font-style: italic;
        }

        .date-left {
            position: absolute;
            top: 454.5pt;
            left: 64.5pt;
            font-size: 12pt;
        }

        .date-left strong { color: #0b3fa4; }
        .date-left span { margin-left: 4.5pt; }

        .signature {
            position: absolute;
            left: 71.25pt;
            top: 477.75pt;
            width: 144pt;
            height: auto;
        }

        .stamp {
            position: absolute;
            left: 147.75pt;
            top: 473.25pt;
            width: 100.5pt;
            height: auto;
        }

        .director {
            position: absolute;
            left: 64.5pt;
            top: 536.25pt;
            font-size: 10.5pt;
            color: #4c4c4c;
        }

        .points {
            position: absolute;
            top: 496.5pt;
            left: 0;
            width: 100%;
            text-align: center;
            color: #0b3fa4;
            font-size: 24.75pt;
            line-height: 1.1;
            font-style: italic;
            font-weight: bold;
        }

        .points-line {
            position: absolute;
            top: 546pt;
            left: 258pt;
            width: 328.5pt;
            height: 1.5pt;
            background: #0b3fa4;
        }

        .issued {
            position: absolute;
            top: 524.25pt;
            right: 64.5pt;
            font-size: 14.25pt;
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="certificate" aria-label="Сертифікат">
            <div class="frame"></div>

            <div class="issuer">{{ $providerName }}</div>
            <h1>СЕРТИФІКАТ</h1>
            <div class="title-line"></div>

            <div class="number">№ {{ $certificateNumber }}</div>
            <div class="person">{{ $fullName ?: 'Прізвище Ім’я По батькові' }}</div>
            <div class="person-line"></div>

            <div class="kind">майстер-клас</div>
            <div class="event">«{{ $courseTitle }}»</div>
            <div class="format">дистанційна участь</div>

            <div class="specialties">
                <strong>Спеціальність, за якою проводилось навчання:</strong><br>
                <em>{{ $specialty }}</em>
            </div>

            <div class="date-left"><strong>Дата:</strong> <span>{{ $issuedAt }}</span></div>
            <img class="signature" src="{{ public_path('cert_html/assets/signature.png') }}" alt="Підпис">
            <img class="stamp" src="{{ public_path('cert_html/assets/stamp.png') }}" alt="Печатка">
            <div class="director">Директор Тищенко Марина Юріївна</div>

            <div class="points">
                2 години@if ($result->webinar->bpr_points), {{ $result->webinar->bpr_points }} балів БПР@endif
            </div>
            <div class="points-line"></div>
            <div class="issued">Видано: <span>{{ $issuedNextDayAt }}</span></div>
        </section>
    </main>
</body>
</html>
