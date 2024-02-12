<div>
    <section class="cta-banner-secondary">

        <div class="container cta-banner-secondary__container">

            <div class="cta-banner-secondary__wrapper">

                <div class="cta-banner-secondary__text">
                    <h6>
                        {{$webinar['lead']}}
                    </h6>
                    <h4>
                        {{$webinar['title']}}
                    </h4>

                    <ul>
                        <li>{{$webinar['date']}}</li>
                        <li>{{$webinar['time']}}</li>
                    </ul>
                </div>

                <div class="cta-banner-secondary__buttons">
                    <div class="price">
                        <p>
                            {{$webinar['price']}}₴
                        </p>
                    </div>
                    <livewire:components.button-add-cart
                            :webinar_id="$webinar_id"

                    />
                </div>

            </div>

        </div>

    </section>
</div>
