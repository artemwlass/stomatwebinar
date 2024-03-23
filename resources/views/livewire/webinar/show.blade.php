<div>
    <main class="webinar-main">

        <section class="webinar">

            <div class="container webinar__container">

                <div class="webinar__wrapper">

                    <div class="webinar__info">

                        <div class="webinar__text">

                            <h5>
                                {{$webinar->title_view_page}}
                            </h5>
                            {!! $webinar->description_view_page !!}

                        </div>

                        <div class="webinar__timer">

                            <p>
                                Залишилося часу
                            </p>

                            <span id="timer">

                            </span>

                        </div>

                    </div>

                    <div class="webinar__stream">
                        <video style="width: 100%;"  oncontextmenu="return false;"
                               id="my-video"
                               class="video-js"
                               controls
                               preload="auto"
                               height="700"
                               data-setup="{}"
                        >
                            <source src="{{asset('storage/' . $webinar->video_view_page)}}" type="video/mp4" />

                        </video>

                    </div>

                </div>

            </div>

        </section>

        <section class="services-opened" style="margin-top: 40px;">

            <div class="container services__container">


                <a href="{{route('account')}}" class="section__link-secondary">
                    Усі доступні вебінари
                </a>


            </div>

        </section>

        <section class="services-blocked">

            <div class="container services__container">

                <a href="#" class="section__link">
                    Закриті вебінари
                </a>

                <div class="row services__row">
                    @foreach($inaccessibleWebinars as $webinar)
                        <div class="col-md-4">
                            <a class="card__img" href="#">
                                <div class="services__card services__card-blocked">
                                    <img class="img-fluid" src="{{asset('storage/' . $webinar->image)}}" alt="">
                                    <a href="#" class="card__info">
                                        <div class="card__title">
                                            <h5>
                                                {{$webinar->title}}
                                            </h5>
                                        </div>
                                        <div class="card__footer">
                                            <div class="card__arrow">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                                                    <path d="M16.7131 27.2868L27.2864 16.7135M27.2864 16.7135L27.2864 25.5246M27.2864 16.7135L18.4753 16.7135" stroke="#47C0F4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div class="card__more" href="#">
                                                {{$webinar->date}}
                                            </div>
                                        </div>
                                    </a>
                                    <div class="services-opened__card-play">
                                        <svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_b_0_1146)">
                                                <rect width="89.3232" height="89.3232" rx="20" fill="#4C4A4A" fill-opacity="0.29"/>
                                            </g>
                                            <g clip-path="url(#clip0_0_1146)">
                                                <path d="M57.8332 38.444V35.8333C57.8332 32.4297 56.4811 29.1655 54.0744 26.7588C51.6677 24.3521 48.4035 23 44.9998 23C41.5962 23 38.332 24.3521 35.9253 26.7588C33.5186 29.1655 32.1665 32.4297 32.1665 35.8333V38.444C30.5337 39.1566 29.1439 40.3296 28.1671 41.8196C27.1903 43.3095 26.6688 45.0518 26.6665 46.8333V57.8333C26.6694 60.2636 27.6361 62.5935 29.3546 64.3119C31.073 66.0304 33.4029 66.9971 35.8332 67H54.1665C56.5968 66.9971 58.9267 66.0304 60.6451 64.3119C62.3636 62.5935 63.3303 60.2636 63.3332 57.8333V46.8333C63.3308 45.0518 62.8094 43.3095 61.8326 41.8196C60.8558 40.3296 59.466 39.1566 57.8332 38.444ZM35.8332 35.8333C35.8332 33.4022 36.7989 31.0706 38.518 29.3515C40.2371 27.6324 42.5687 26.6667 44.9998 26.6667C47.431 26.6667 49.7626 27.6324 51.4816 29.3515C53.2007 31.0706 54.1665 33.4022 54.1665 35.8333V37.6667H35.8332V35.8333ZM59.6665 57.8333C59.6665 59.292 59.087 60.691 58.0556 61.7224C57.0241 62.7539 55.6252 63.3333 54.1665 63.3333H35.8332C34.3745 63.3333 32.9755 62.7539 31.9441 61.7224C30.9126 60.691 30.3332 59.292 30.3332 57.8333V46.8333C30.3332 45.3746 30.9126 43.9757 31.9441 42.9442C32.9755 41.9128 34.3745 41.3333 35.8332 41.3333H54.1665C55.6252 41.3333 57.0241 41.9128 58.0556 42.9442C59.087 43.9757 59.6665 45.3746 59.6665 46.8333V57.8333Z" fill="white"/>
                                                <path d="M44.9998 48.666C44.5136 48.666 44.0473 48.8592 43.7035 49.203C43.3597 49.5468 43.1665 50.0131 43.1665 50.4993V54.166C43.1665 54.6522 43.3597 55.1185 43.7035 55.4624C44.0473 55.8062 44.5136 55.9993 44.9998 55.9993C45.4861 55.9993 45.9524 55.8062 46.2962 55.4624C46.64 55.1185 46.8332 54.6522 46.8332 54.166V50.4993C46.8332 50.0131 46.64 49.5468 46.2962 49.203C45.9524 48.8592 45.4861 48.666 44.9998 48.666Z" fill="white"/>
                                            </g>
                                            <defs>
                                                <filter id="filter0_b_0_1146" x="-13" y="-13" width="115.323" height="115.323" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feGaussianBlur in="BackgroundImageFix" stdDeviation="6.5"/>
                                                    <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_0_1146"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_0_1146" result="shape"/>
                                                </filter>
                                                <clipPath id="clip0_0_1146">
                                                    <rect width="44" height="44" fill="white" transform="translate(23 23)"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>



            </div>

        </section>
    </main>
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script src="{{asset('js/videojs-dynamic-watermark/dist/videojs-dynamic-watermark.min.js')}}"></script>
    <!-- Подключение скрипта плагина водяного знака -->
{{--    <script src="https://cdn.jsdelivr.net/npm/videojs-awesome-watermark@0.0.12/dist/videojs-awesome-watermark.min.js"></script>--}}
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        var player = videojs('my-video');

        if (!player) {
            console.error("Ошибка: не удалось найти видеоплеер.");
        } else {
            player.dynamicWatermark({
                elementId: "unique_id",
                watermarkText: "{{\Illuminate\Support\Facades\Auth::user()->email}}",
                changeDuration: 1000000,
                cssText: "display: inline-block; color: grey; background-color: transparent; font-size: 1rem; z-index: 9999; position: absolute; @media only screen and (max-width: 992px){font-size: 0.8rem;}"
            });
        }

        {{--player.awesomeWatermark({--}}
        {{--        type: 'text',--}}
        {{--        text: '{{\Illuminate\Support\Facades\Auth::user()->email}}', // Текст водяного знака--}}
        {{--        fontColor: 'white', // Цвет шрифта--}}
        {{--        fontFamily: 'Arial', // Шрифт--}}
        {{--        fontSize: '1rem', // Размер шрифта--}}
        {{--        fontSizeUnit: 'pixels', // Единица измерения размера шрифта--}}
        {{--        position: 'center', // Позиция водяного знака--}}
        {{--    });--}}
        {{--}--}}

        // JSON-кодирование переменной daysRemaining
        var daysRemaining = {!! json_encode($daysRemaining) !!};
        var timerElement = document.getElementById('timer');
        if (!timerElement) {
            console.error("Ошибка: не удалось найти элемент таймера.");
        } else {
            if (daysRemaining === 'Бессрочно') {
                timerElement.textContent = 'Бессрочно';
            } else if (daysRemaining >= 1) {
                daysRemaining = isNaN(parseInt(daysRemaining)) ? daysRemaining : parseInt(daysRemaining);
                timerElement.textContent = daysRemaining + (daysRemaining === 1 ? ' день' : ' дні');
            } else {
                function updateTimer() {
                    let now = new Date();
                    let webinarDate = new Date(); // текущая дата
                    webinarDate.setDate(webinarDate.getDate() + 1); // установка на следующий день
                    webinarDate.setHours(0, 0, 0, 0); // установка на начало дня

                    let remainingTime = Math.floor((webinarDate - now) / 1000);
                    let hours = Math.floor(remainingTime / 3600);
                    let minutes = Math.floor((remainingTime % 3600) / 60);
                    let seconds = remainingTime % 60;

                    let formattedTime = `${String(hours).padStart(2, '0')} : ${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;

                    timerElement.textContent = formattedTime;

                    if (remainingTime <= 0) {
                        clearInterval(intervalId);
                        timerElement.textContent = 'ВЕБИНАР В ЭФИРЕ';
                    }
                }

                let intervalId = setInterval(updateTimer, 1000);
            }
        }
    </script>


</div>
