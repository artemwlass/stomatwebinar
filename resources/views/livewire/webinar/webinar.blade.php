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
                        <a class="breadcrumbs__link breadcrumbs__prev" href="#">Всі вебінари</a>
                    </li>
                    <span class="breadcrumbs__divider">
                            /
                        </span>
                    <li class="breadcrumbs__item">
                        <span class="breadcrumbs__current">{{$webinar->title}}</span>
                    </li>
                </ol>
            </nav>


        </div>

        @foreach ($webinar->content as $item)
            @switch($item['type'])
                @case(0)
                    <livewire:webinar.components.main-first-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(1)
                    <livewire:webinar.components.benefits-block :webinar="$item"/>
                    @break
                @case(2)
                    <livewire:webinar.components.webinar-about-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(3)
                    <livewire:webinar.components.banner-secondary-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(4)
                    <livewire:components.faq :webinar="$item"/>
                    @break
                @case(5)
                    <livewire:webinar.components.webinar-about-image-right-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(6)
                    <livewire:webinar.components.slider-block :webinar="$item"/>
                    @break
                @case(7)
                    <livewire:webinar.components.webinar-about-image-left-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(8)
                    <livewire:webinar.components.webinar-about-right-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(9)
                    <livewire:webinar.components.services :webinar="$item"/>
                    @break
                @case(10)
                    <livewire:webinar.components.main-discount :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
            @endswitch
        @endforeach
        <livewire:components.support />
    </main>
</div>
