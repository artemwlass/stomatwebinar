<div>
    @dd(\Gloudemans\Shoppingcart\Facades\Cart::content())
    <main>
        <livewire:home.components.hero-block :home="$home->block_hero"/>
        <livewire:home.components.highlight-block :home="$home->block_highlight"/>
        <livewire:home.components.services-block :home="$home->is_active_service"/>
        <livewire:home.components.about-block :home="$home->block_about"/>
        <livewire:home.components.swiper-block :home="$home->schedule_webinar"/>
        <livewire:home.components.schedule-block :home="$home->schedule_lesson"/>
        <livewire:home.components.cta-banner-block :home="$home->second_banner"/>
        <livewire:home.components.service-free-block />
        <livewire:home.components.faq-block />

        <livewire:components.support />

    </main>
</div>
