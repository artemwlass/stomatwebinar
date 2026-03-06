Имя: {{$user->name}}
Фамилия: {{$user->surname}}
Телефон: {{$user->phone}}
Почта: {{$user->email}}

Купленные вебинары:
@foreach($webinars as $value)
{{$value->webinar->title}} - {{$value->price}}
@endforeach

Сумма покупки: {{$event->order->amount}}

@php
    $attr = $paymentAttempt->attribution_data ?? [];
@endphp

Ссылка перехода: {{ $attr['landing_url'] ?? '-' }}
