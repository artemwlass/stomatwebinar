<div>
    <section class="webinar-about">

        <div class="container webinar-about__container">

            <div class="webinar-about__wrapper">

                <div class="webinar-about__img">
                    <img src="{{asset('storage/' . $webinar['image'])}}" alt="" style="max-height: 700px;">
                </div>

                <div class="webinar-about__info webinar-banner__info-secondary">
                    {!! $webinar['description'] !!}

                    <livewire:components.button-add-cart
                            :webinar_id="$webinar_id"
                            :color_button="'blue'"

                    />
                </div>

            </div>



        </div>

    </section>
</div>
