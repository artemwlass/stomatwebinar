<div>
    <main>

        <div class="container breadcrumb__container">


        </div>

        @foreach ($webinar->content as $item)
            @switch($item['type'])
                @case(0)
                    <livewire:free-webinar-preorder.components.main-first-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(1)
                    <livewire:free-webinar-preorder.components.benefits-block :webinar="$item"/>
                    @break
                @case(2)
                    <livewire:free-webinar-preorder.components.webinar-about-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(3)
                    <livewire:free-webinar-preorder.components.banner-secondary-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(4)
                    <livewire:components.faq :webinar="$item"/>
                    @break
                @case(5)
                    <livewire:free-webinar-preorder.components.webinar-about-image-right-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(6)
                    <livewire:free-webinar-preorder.components.slider-block :webinar="$item"/>
                    @break
                @case(7)
                    <livewire:free-webinar-preorder.components.webinar-about-image-left-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(8)
                    <livewire:free-webinar-preorder.components.webinar-about-right-block :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(9)
                    <livewire:free-webinar-preorder.components.services :webinar="$item"/>
                    @break
                @case(10)
                    <livewire:free-webinar-preorder.components.video :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
                @case(11)
                    <livewire:free-webinar-preorder.components.form :webinar="$item" :webinar_id="$webinar->id"/>
                    @break
            @endswitch
        @endforeach
        <livewire:components.support />
    </main>

</div>
