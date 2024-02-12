<div>
    <main>

        <livewire:home.components.hero-block :home="$home->block_hero"/>
        <livewire:home.components.highlight-block :home="$home->block_highlight"/>
        <livewire:home.components.services-block />
        <livewire:home.components.about-block :home="$home->block_about"/>
        <livewire:home.components.swiper-block :home="$home->schedule_webinar"/>
        <livewire:home.components.schedule-block :home="$home->schedule_lesson"/>
        <livewire:home.components.cta-banner-block />
        <livewire:home.components.service-free-block />
        <livewire:home.components.faq-block />

        <livewire:components.support />

    </main>
</div>
