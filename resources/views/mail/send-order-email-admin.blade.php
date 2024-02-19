Имя: {{$user->name}}<br>
Фамилия: {{$user->surname}}<br>
Телефон: {{$user->phone}}<br>
Почта: {{$user->email}}<br><br>

Купленные вебинары:
@foreach($webinars as $value)
    {{$value->webinar->title}} - {{$value->price}}<br><br>
@endforeach

Сумма покупки: {{$event->order->amount}}
