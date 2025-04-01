<div>
    <section class="faq">

        <div class="container accordion__container">

            <p class="section__link">
                Поширені запитання
            </p>

            <div class="accordion">

                @foreach($data as $value)
                    <div class="accordion__item">
                        <button class="accordion__btn">

                            <span class="accordion__caption">{{$value->question}}</span>
                            <span class="accordion__icon"><i class="fa fa-plus"></i></span>
                        </button>

                        <div class="accordion__content">
                            <ul>
                                <li>
                                    <p>
                                        {{$value->answer}}
                                    </p>
                                </li>

                            </ul>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </section>
</div>
