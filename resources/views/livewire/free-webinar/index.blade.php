<div>
    <main>

        <div class="container breadcrumb__container">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumbs__item">
                        <a class="breadcrumbs__link breadcrumbs__prev" href="/">Головна</a>
                    </li>
                    <span class="breadcrumbs__divider">
                            /
                        </span>
                    <li class="breadcrumbs__item">
                        <span class="breadcrumbs__current">Безкоштовні вебінари</span>
                    </li>
                </ol>
            </nav>


        </div>

        <section class="inner-page__blog">

            <div class="container inner-page__container">

                <div class="inner-page__title">

                    <h3>
                        {{$title}}
                    </h3>


                </div>

            </div>

        </section>

        <section class="free-webinars">

            <div class="container free-webinars__container">

                <div class="row free-webinars__row">

                    @foreach($webinars as $webinar)
                    <div class="col-md-6">
                        <a class="card__img" href="#">
                            <div class="services__card free-webinars__card" data-video-url="{{$webinar->link}}">
                                <img class="img-fluid" src="{{asset('storage/' . $webinar->image)}}" alt="">
                                <iframe class="video-frame" width="1280" height="720" title="Поширені ураження слизової оболонки." frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>


                                <a href="#" class="card__info">
                                    <div class="card__title" href="#">
                                        <h5>
                                            {{$webinar->name}}
                                        </h5>
                                    </div>
                                    <div class="card__footer">
                                        <div class="card__arrow" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                                                <path d="M16.7131 27.2868L27.2864 16.7135M27.2864 16.7135L27.2864 25.5246M27.2864 16.7135L18.4753 16.7135" stroke="#47C0F4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div class="card__more" href="#">
                                            {{$webinar->lead}}
                                        </div>
                                    </div>
                                </a>
                                <p class="section__link-secondary webinar__author">
                                    {{$webinar->lead}}
                                </p>
                                <div class="services-opened__card-play">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
                                        <g filter="url(#filter0_b_0_1352)">
                                            <rect width="89.3232" height="89.3232" rx="20" fill="#4C4A4A" fill-opacity="0.29"/>
                                        </g>
                                        <path d="M60.905 41.4922C62.985 43.0934 62.985 46.2302 60.905 47.8314L40.4292 63.5937C37.7989 65.6185 33.9892 63.7434 33.9892 60.4241V28.8995C33.9892 25.5801 37.7989 23.7051 40.4292 25.7299L60.905 41.4922Z" fill="white" fill-opacity="0.86"/>
                                        <defs>
                                            <filter id="filter0_b_0_1352" x="-13" y="-13" width="115.323" height="115.323" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feGaussianBlur in="BackgroundImageFix" stdDeviation="6.5"/>
                                                <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_0_1352"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_0_1352" result="shape"/>
                                            </filter>
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
</div>
