<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>{{ $fileName }}</title>
    <style>
        @page {
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #111111;
            background: #f5f7fb;
        }

        .page {
            position: relative;
            width: 794px;
            height: 1123px;
            margin: 0 auto;
            overflow: hidden;
            background: #ffffff;
        }

        .shape-top,
        .shape-bottom {
            position: absolute;
            left: 0;
            width: 100%;
            z-index: 1;
        }

        .shape-top {
            top: 0;
            height: 250px;
        }

        .shape-bottom {
            bottom: 0;
            height: 270px;
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 132px 54px 140px;
            text-align: center;
        }

        .brand {
            margin-bottom: 42px;
        }

        .brand-mark {
            width: 58px;
            height: 58px;
            border: 4px solid #2e86de;
            border-top-color: transparent;
            border-right-color: #7e57c2;
            border-radius: 50%;
            margin: 0 auto 14px;
        }

        .brand-name {
            font-size: 18px;
            color: #7c7c7c;
        }

        .title {
            margin: 0 0 14px;
            font-size: 54px;
            letter-spacing: 20px;
            font-weight: 400;
            color: #2e86de;
        }

        .file-number {
            margin-bottom: 6px;
            font-size: 24px;
            font-weight: 700;
        }

        .subtitle {
            font-size: 26px;
            color: #4f4f4f;
            margin-bottom: 24px;
        }

        .name {
            margin: 0 0 20px;
            font-size: 46px;
            line-height: 1.12;
            font-weight: 700;
        }

        .lead {
            font-size: 28px;
            color: #4f4f4f;
            margin-bottom: 10px;
        }

        .program {
            font-size: 40px;
            line-height: 1.18;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .specialty {
            font-size: 18px;
            color: #6a6a6a;
            line-height: 1.45;
            margin: 0 auto 24px;
            max-width: 650px;
        }

        .score {
            font-size: 20px;
            line-height: 1.55;
            font-weight: 700;
            margin: 0 auto;
            max-width: 680px;
        }

        .footer {
            position: absolute;
            left: 56px;
            right: 56px;
            bottom: 86px;
            z-index: 2;
        }

        .footer-line {
            width: 210px;
            border-top: 2px solid #3c3c3c;
            margin-bottom: 12px;
        }

        .footer-sign {
            font-size: 18px;
            color: #3c3c3c;
        }

        .footer-date {
            position: absolute;
            right: 0;
            bottom: 0;
            font-size: 22px;
            font-weight: 700;
            color: #3c3c3c;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="shape-top">
            <svg width="794" height="250" viewBox="0 0 794 250" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="0,0 794,0 794,78 0,160" fill="#285AB3"/>
                <polygon points="0,46 278,0 530,0 0,188" fill="#7E7FA2" opacity="0.9"/>
                <polygon points="794,0 794,168 480,0" fill="#8AC4F8" opacity="0.85"/>
                <polygon points="0,160 397,250 794,160 794,220 397,250 0,220" fill="#FFFFFF"/>
            </svg>
        </div>

        <div class="content">
            <div class="brand">
                <div class="brand-mark"></div>
                <div class="brand-name">{{ config('certificates.provider_name') }}</div>
            </div>

            <div class="title">CERTIFICATE</div>
            <div class="file-number">{{ pathinfo($fileName, PATHINFO_FILENAME) }}</div>
            <div class="subtitle">засвідчує, що</div>

            <h1 class="name">{{ $fullName }}</h1>
            <div class="lead">був(-ла) учасником майстер-класу</div>
            <div class="program">{{ $result->webinar->title }}</div>

            <div class="specialty">
                {{ $result->user->specialty ?: 'Спеціальність не вказана' }}
            </div>

            <div class="score">
                та набрав(-ла) {{ $result->score_percent }}% правильних відповідей за критеріями нарахування балів безперервного професійного розвитку
                @if ($result->webinar->bpr_points)
                    ({{ $result->webinar->bpr_points }} балів БПР)
                @endif
            </div>
        </div>

        <div class="footer">
            <div class="footer-line"></div>
            <div class="footer-sign">Підпис провайдера</div>
            <div class="footer-date">{{ optional($result->passed_at)->format('d.m.Y') }}</div>
        </div>

        <div class="shape-bottom">
            <svg width="794" height="270" viewBox="0 0 794 270" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="0,130 250,270 0,270" fill="#8AC4F8" opacity="0.9"/>
                <polygon points="0,88 360,270 110,270" fill="#5C7FC5" opacity="0.92"/>
                <polygon points="794,108 794,270 530,270" fill="#7E7FA2" opacity="0.9"/>
                <polygon points="794,72 794,270 408,270" fill="#285AB3" opacity="0.9"/>
                <polygon points="180,270 397,170 620,270" fill="#FFFFFF"/>
            </svg>
        </div>
    </div>
</body>
</html>
