<div>
        @if(count($faq))
        <section class="faq">

            <div class="container accordion__container">

                <a href="" class="section__link">
                    Поширені запитання
                </a>

                <div class="accordion">


                    @foreach($faq as $item)
                        <div class="accordion__item">
                            <button class="accordion__btn">

                                <span class="accordion__caption">{{$item->question}}</span>
                                <span class="accordion__icon"><i class="fa fa-plus"></i></span>
                            </button>

                            <div class="accordion__content">
                                <ul>
                                    <li>
                                        {!! $item->answer !!}
                                    </li>

                                </ul>

                            </div>
                        </div>
                    @endforeach


                </div>

            </div>

        </section>
        @endif

</div>
