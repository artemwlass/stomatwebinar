<div>
    @if($home['is_active'] == true)
        <section class="schedule">
            <div class="container schedule__container desktop">
                <img src="{{asset('storage/' . $home['desktop'])}}">
            </div>

            <div class="container schedule__container mobile">
                <img src="{{asset('storage/' . $home['mob'])}}">
            </div>
        </section>
{{--        <section class="schedule">--}}
{{--            <div class="container schedule__container">--}}
{{--                <p class="section__link">--}}
{{--                    Розклад лекцій--}}
{{--                </p>--}}
{{--                <div class="row schedule__row">--}}
{{--                    @foreach($home['data'] as $value)--}}
{{--                        <div class="col-md-6">--}}
{{--                            <a class="schedule__card">--}}
{{--                                <div class="city">--}}
{{--                                    <p>{{$value['city']}}</p>--}}
{{--                                </div>--}}
{{--                                <div class="title">--}}
{{--                                    <p>{{$value['text']}}</p>--}}
{{--                                </div>--}}
{{--                                <div class="date">--}}
{{--                                    <p>{{$value['data']}}</p>--}}
{{--                                </div>--}}
{{--                                <div class="link">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44"--}}
{{--                                         fill="none">--}}
{{--                                        <path--}}
{{--                                            d="M16.7136 27.2866L27.2869 16.7133M27.2869 16.7133L27.2869 25.5244M27.2869 16.7133L18.4758 16.7133"--}}
{{--                                            stroke="#47C0F4" stroke-width="2" stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"/>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
    @endif
</div>
