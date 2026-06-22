<main class="casey-content-page">
    <section class="dashboard">
        <div class="dashboard-container">
            @include('livewire.account.partials.sidebar', [
                'active' => 'cases',
                'mobileLabel' => 'Кейси',
                'mobileIcon' => 'account_assets/images/nav-link-icon-6-active.svg',
            ])

            <div class="dashboard-right">
                <section class="casey casey-content">
                    <nav class="casey-content__breadcrumb">
                        <a href="{{ route('account.cases') }}">Кейси</a>
                        <span aria-hidden="true">›</span>
                        <span>Основний зміст кейсу</span>
                    </nav>

                    <div class="casey-content__tags lightblue">
                        <span class="tarif-navs__tag">Автор: {{ $case->author_name }}</span>
                        @if ($case->user?->specialty)
                            <span class="tarif-navs__tag">Спеціальність: {{ $case->user->specialty }}</span>
                        @endif
                        <span class="tarif-navs__tag">
                            Опубліковано: {{ $case->published_at?->locale('uk')->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <h2>{{ $case->title }}</h2>
                    <div class="casey-content__badge">Основний зміст кейсу</div>

                    <div class="casey-content__body">
                        @foreach ([
                            'Стать' => $case->gender,
                            'Вік' => $case->age !== null ? $case->age . ' років' : null,
                            'Скарги' => $case->complaints,
                            'Загальносоматичний анамнез' => $case->medical_history,
                            'Обстеження' => $case->examination,
                        ] as $label => $value)
                            @if (filled($value))
                                <div class="casey-content__row">
                                    <div class="casey-content__label">{{ $label }}</div>
                                    <div class="casey-content__value">{{ $value }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="casey-content__text">
                        @foreach (preg_split('/\R{2,}/u', trim($case->content)) ?: [] as $paragraph)
                            <p>{!! nl2br(e($paragraph)) !!}</p>
                        @endforeach
                    </div>

                    @if (! empty($case->media))
                        <div class="casey-content__slider" wire:ignore>
                            @if (count($case->media) > 1)
                                <div class="casey-content__slider-nav">
                                    <button type="button" class="casey-slider-prev" aria-label="Попередній файл">←</button>
                                    <button type="button" class="casey-slider-next" aria-label="Наступний файл">→</button>
                                </div>
                            @endif

                            <div class="swiper casey-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($case->media as $media)
                                        <div class="swiper-slide">
                                            @if ($case->isVideo($media))
                                                <video controls preload="metadata">
                                                    <source src="{{ asset('storage/' . $media) }}">
                                                </video>
                                            @else
                                                <img src="{{ asset('storage/' . $media) }}" alt="{{ $case->title }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="casey-comments">
                        <h3>Коментарі ({{ $comments->count() }})</h3>

                        <form class="casey-comments__form" wire:submit="addComment">
                            <div class="casey-comments__form-head">
                                <div class="casey-comments__avatar">
                                    <img src="{{ asset('account_assets/images/user-logo.svg') }}" alt="">
                                </div>
                                <span class="casey-comments__name">{{ trim(auth()->user()->surname . ' ' . auth()->user()->name) }}</span>
                            </div>

                            <textarea wire:model="comment" class="casey-comments__textarea" placeholder="Напишіть коментар..."></textarea>
                            @error('comment') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <div class="casey-comments__toolbar">
                                <span class="casey-comments__hint">До 5000 символів</span>
                                <button type="submit" class="casey-comments__submit">Відправити</button>
                            </div>
                        </form>

                        <div class="casey-comments__list">
                            @forelse ($comments as $item)
                                <article class="casey-comments__item" wire:key="case-comment-{{ $item->id }}">
                                    <div class="casey-comments__item-head">
                                        <div class="casey-comments__avatar">
                                            <img src="{{ asset('account_assets/images/user-logo.svg') }}" alt="">
                                        </div>
                                        <span class="casey-comments__name">
                                            {{ trim($item->user->surname . ' ' . $item->user->name) ?: $item->user->email }}
                                        </span>
                                    </div>
                                    <p class="casey-comments__text">{!! nl2br(e($item->body)) !!}</p>
                                    <time class="casey-comments__time" datetime="{{ $item->created_at->toIso8601String() }}">
                                        {{ $item->created_at->locale('uk')->diffForHumans() }}
                                    </time>
                                </article>
                            @empty
                                <p class="casey-comments__empty">Коментарів поки немає.</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    @if (count($case->media ?? []) > 1)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                new Swiper('.casey-swiper', {
                    slidesPerView: 1.15,
                    spaceBetween: 16,
                    navigation: {
                        prevEl: '.casey-slider-prev',
                        nextEl: '.casey-slider-next',
                    },
                    breakpoints: {
                        768: { slidesPerView: 2.2, spaceBetween: 24 },
                        1200: { slidesPerView: 3, spaceBetween: 32 },
                    },
                });
            });
        </script>
    @endif
</main>
