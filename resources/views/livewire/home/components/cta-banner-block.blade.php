<div>
    @if($home['is_active'] == true)
    <section class="cta-banner" id="cta-banner-primary">

        <div class="container cta-banner__container">

            <div class="cta-banner__wrapper">

                <div class="cta-banner__info">
                    <h1>
                        {!! $home['title'] !!}
                    </h1>

                    {!! $home['description'] !!}

                    <div class="cta-banner__buttons">
                        <p class="section__button-outlined white" href="" style="font-size: 30px;padding: 14px 52px;">
                            {{$home['price']}}₴
                        </p>

                        <a href="{{$home['link']}}" class="section__button-primary white">
                            Сплатити
                        </a>
                    </div>


                </div>

                <div class="cta-banner__img">
                    <img class="img-fluid" src="{{asset('storage/' . $home['image'])}}" alt="">
                </div>

            </div>

        </div>

    </section>
    @endif
</div>
