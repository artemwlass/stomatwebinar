Шановний(а) {{ trim(($result->user->surname ?? '') . ' ' . ($result->user->name ?? '')) ?: $result->user->email }},<br><br>

Надсилаємо Ваш сертифікат за вебінар:<br>
<strong>{{ $result->webinar->title }}</strong><br><br>

Номер сертифіката: <strong>{{ \App\Support\CertificatePresenter::number($result) }}</strong><br>
Дата видачі: <strong>{{ $result->passed_at?->copy()->timezone(config('app.display_timezone'))->format('d.m.Y') ?? '—' }}</strong><br><br>

Сертифікат прикріплено до цього листа у форматі PDF.<br><br>

З повагою,<br>
Команда stomatwebinar.com
