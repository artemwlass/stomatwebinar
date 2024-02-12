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
                        <span class="breadcrumbs__current">Блог</span>
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
                    {!! $description !!}

                </div>

            </div>

        </section>

        <section class="blog-list">

            <div class="container blog-list__container">

                <div class="row blog-list__row">
                @foreach($posts as $post)
                    <div class="col-md-6">

                        <div class="blog-card">

                            <a class="blog-img" href="{{route('post', $post->slug)}}">
                                <img class="img-fluid" src="{{asset('storage/' . $post->image)}}" alt="">
                            </a>

                            <a href="{{route('post', $post->slug)}}">
                                <h5>
                                    {{$post->title}}
                                </h5>
                            </a>
                            <a href="{{route('post', $post->slug)}}">
                                <p>
                                    Нажмите на кнопку подробнее и читайте нашу статью
                                </p>
                            </a>

                            <a href="{{route('post', $post->slug)}}" class="section__link-secondary">
                                Подробнее
                            </a>

                        </div>

                    </div>
                @endforeach
                </div>

            </div>

        </section>

    </main>
</div>
