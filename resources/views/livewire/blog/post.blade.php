<main>
    <section class="dashboard account-blog-page">
        <div class="dashboard-container">
            @include('livewire.account.partials.sidebar', [
                'active' => 'blog',
                'mobileLabel' => 'Блог',
                'mobileIcon' => 'account_assets/images/nav-link-icon-1-active.svg',
            ])

            <div class="dashboard-right">
                <article class="account-blog-post">
                    <a href="{{ route('blog') }}" class="account-blog-post__back">
                        <span aria-hidden="true">←</span>
                        <span>Усі статті</span>
                    </a>

                    <header class="account-blog-post__head">
                        <span class="account-blog__eyebrow">Блог</span>
                        <h1>{{ $post->title }}</h1>
                        <time datetime="{{ $post->created_at?->toDateString() }}">
                            {{ $post->created_at?->locale('uk')->translatedFormat('d F Y') }}
                        </time>
                    </header>

                    @if ($post->image)
                        <div class="account-blog-post__cover">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="account-blog-article">
                        {!! $post->text !!}
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>
