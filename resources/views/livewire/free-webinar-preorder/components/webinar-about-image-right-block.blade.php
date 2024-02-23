<div>
    <section class="webinar-about">

        <div class="container webinar-about__container">

            <div class="webinar-about__wrapper">

                <div class="webinar-about__info">
                    {!! $webinar['description'] !!}

                </div>

                <div class="webinar-about__img">
                    <img src="{{asset('storage/' . $webinar['image'])}}" alt="">
                </div>

            </div>

            <article>
                {!! $webinar['description2'] !!}
            </article>



        </div>

    </section>
</div>
