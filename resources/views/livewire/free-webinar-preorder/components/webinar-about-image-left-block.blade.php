<div>
    <section class="webinar-about">

        <div class="container webinar-about__container">

            <div class="webinar-about__wrapper">

                <div class="webinar-about__img">
                    <img src="{{asset('storage/' . $webinar['image'])}}" alt="" style="max-height: 700px;">
                </div>

                <div class="webinar-about__info webinar-about__info-secondary">
                    {!! $webinar['description'] !!}

                </div>



            </div>

            <article>

                {!! $webinar['description2'] !!}

            </article>

        </div>

    </section>
</div>
