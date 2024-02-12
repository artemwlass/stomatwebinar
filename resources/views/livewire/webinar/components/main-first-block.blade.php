<div>
    <section class="webinar-banner">
        <div class="container webinar-banner__container">

            <div class="webinar-banner__wrapper">

                <div class="webinar-banner__info we">

                    <div class="webinar-banner__date">

                        <p>
                            {{$webinar['date']}}
                        </p>

                        <p>
                            {{$webinar['time']}}
                        </p>

                    </div>

                    <h1>
                        {{$webinar['title']}}
                    </h1>

                    <ul>
                        @foreach($webinar['tags'] as $tag)
                        <li>
                            {{$tag}}
                        </li>
                        @endforeach
                    </ul>

                    <div class="webinar-banner__bottom desktop">
                        <p>
                            {{$webinar['price']}}₴
                        </p>
                        <livewire:components.button-add-cart
                                :webinar_id="$webinar_id"
                                :color_button="'blue'"

                        />
                    </div>
                </div>

                <div class="webinar-banner__img">
                    <img class="img-fluid" src="{{asset('storage/' . $webinar['banner'])}}" alt="">

                </div>

                <div class="webinar-banner__bottom mobile">
                    <p>
                        {{$webinar['price']}}₴
                    </p>
                    <livewire:components.button-add-cart
                            :webinar_id="$webinar_id"
                            :webinar_price="$webinar['price']"
                            :webinar_title="$webinar['title']"
                            :webinar_date="$webinar['date']"
                            :webinar_time="$webinar['time']"

                    />
                </div>

            </div>

        </div>
    </section>
</div>
