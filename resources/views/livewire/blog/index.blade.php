<main>
    <section class="dashboard account-blog-page">
        <div class="dashboard-container">
            @include('livewire.account.partials.sidebar', [
                'active' => 'blog',
                'mobileLabel' => 'Блог',
                'mobileIcon' => 'account_assets/images/nav-link-icon-1-active.svg',
            ])

            <div class="dashboard-right">
                <section class="account-blog">
                    <div class="account-blog__head">
                        <span class="account-blog__eyebrow">База знань</span>
                        <h1>{{ $title }}</h1>
                        <div class="account-blog__description">{!! $description !!}</div>
                    </div>

                    <div class="account-blog__grid">
                        @forelse ($posts as $post)
                            <article class="account-blog-card" wire:key="blog-post-{{ $post->id }}">
                                <a href="{{ route('post', $post->slug) }}" class="account-blog-card__media">
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                    @else
                                        <span>{{ mb_substr($post->title, 0, 1) }}</span>
                                    @endif
                                </a>
                                <div class="account-blog-card__body">
                                    <time datetime="{{ $post->created_at?->toDateString() }}">
                                        {{ $post->created_at?->locale('uk')->translatedFormat('d F Y') }}
                                    </time>
                                    <h2><a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a></h2>
                                    <a href="{{ route('post', $post->slug) }}" class="account-blog-card__link">
                                        <span>Читати статтю</span>
                                        <span aria-hidden="true">↗</span>
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="account-blog__empty">Опублікованих статей поки немає.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>
