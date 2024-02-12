<div>
    <section class="services" id="services">

        <div class="container services__container">

            <p class="section__link">
                Вебінари в записі
            </p>

            <div class="row services__row">

                @foreach($webinars as $webinar)
                <div class="col-md-4 {{ $loop->index >= 9 ? 'hidden' : '' }}">
                    <a class="card__img" href="{{route('webinar.show', $webinar->slug)}}">
                        <div class="services__card">
                            <img class="img-fluid" src="{{asset('storage/' . $webinar->image)}}" alt="">
                            <a href="{{route('webinar.show', $webinar->slug)}}" class="card__info">
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
                                    <div class="card__more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                                            <g>
                                                <path d="M7.99235 6.18163C6.77629 6.74813 5.742 7.72503 4.70695 9.15331C4.55933 9.35699 4.55339 9.48075 4.70503 9.59021C4.81164 9.66717 4.87359 9.64255 5.02886 9.47688C5.04965 9.45457 5.04965 9.45457 5.0709 9.43151C5.20513 9.28615 5.31326 9.1628 5.54424 8.89456C6.30743 8.00827 6.68021 7.64347 7.25957 7.30983C7.76092 7.02113 8.20153 7.44541 8.11763 7.9884C8.0941 8.14081 8.05355 8.2533 7.94909 8.49485C7.90754 8.59094 7.89001 8.63273 7.87053 8.68396C7.68223 9.17896 7.52363 9.59189 7.1913 10.4543L7.1754 10.4955C7.07492 10.7563 7.07492 10.7563 6.97452 11.017C6.53928 12.1482 6.27516 12.8418 6.00266 13.5754L5.98668 13.6184C5.91355 13.8151 5.87911 13.9078 5.84105 14.011C5.5288 14.8578 5.35024 15.408 5.21442 15.9932C5.19322 16.0842 5.19321 16.0842 5.17171 16.1768C5.09519 16.5078 5.05424 16.7211 5.03135 16.9403C4.99177 17.3195 5.02359 17.6299 5.14273 17.8908C5.27754 18.1861 5.56721 18.3973 5.89772 18.4452C6.44828 18.5251 6.97953 18.5195 7.43453 18.4159C7.6906 18.3577 7.94395 18.2815 8.19253 18.1881C8.91228 17.9175 9.60567 17.4952 10.2773 16.9371C10.8649 16.4473 11.4209 15.8507 12.0038 15.1093C12.0546 15.0451 12.0546 15.0451 12.1053 14.981C12.2813 14.7565 12.3676 14.6106 12.3998 14.4566C12.4348 14.2894 12.2935 14.1199 12.1805 14.1766C12.1246 14.2047 12.0662 14.2627 11.9772 14.3749C11.9136 14.4566 11.8789 14.5003 11.8443 14.5395C11.7061 14.696 11.5601 14.8562 11.402 15.0255C11.1412 15.3044 10.8763 15.5773 10.4921 15.9659C10.2964 16.1637 10.0503 16.3367 9.78565 16.4668C9.36213 16.6749 8.98007 16.4126 9.02596 15.9431C9.05623 15.6332 9.13131 15.3128 9.24357 15.0031C9.48879 14.326 9.6893 13.7787 10.1329 12.5724C10.3253 12.0493 10.4083 11.8233 10.5121 11.5404C10.8197 10.702 11.0652 10.0271 11.2988 9.37591C11.5874 8.5715 11.7504 7.97189 11.8259 7.35269C11.8829 6.88565 11.753 6.439 11.4567 6.13191C11.1281 5.79149 10.6608 5.63467 10.0787 5.64155C9.43475 5.64921 8.68355 5.85962 7.99235 6.18163ZM12.4003 0.629528C11.2431 0.179265 9.85437 0.952806 9.62184 2.17799C9.45324 3.06599 9.78497 3.83266 10.462 4.15378C11.8042 4.79031 13.415 3.77037 13.4151 2.28377C13.4151 1.45679 13.0619 0.886974 12.4003 0.629528Z" fill="white"/>
                                            </g>
                                        </svg>
                                        Детальніше
                                    </div>
                                </div>
                            </a>
                        </div>
                    </a>
                </div>
                @endforeach


            </div>

            <a href="" class="section__link-secondary" id="showHiddenCards">
                Усі вебінари у записі
            </a>

            <script>
                // Логика кнопки Усі вебінари у записі
                document.getElementById('showHiddenCards').addEventListener('click', function(event) {
                    event.preventDefault(); // Предотвращаем переход по ссылке

                    // Получаем все элементы с классом 'col-md-4.hidden' и убираем у них класс 'hidden'
                    var hiddenCards = document.querySelectorAll('.col-md-4.hidden');
                    hiddenCards.forEach(function(card) {
                        card.classList.remove('hidden');
                        card.classList.add('visible'); // Добавляем класс 'visible'
                    });

                    // Удаляем кнопку
                    var button = document.getElementById('showHiddenCards');
                    button.parentNode.removeChild(button);
                });


            </script>


        </div>

    </section>
</div>
