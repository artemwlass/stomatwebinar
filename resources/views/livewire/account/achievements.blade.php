<div class="achievements-page">
    <main>
        <section class="dashboard">
            <div class="dashboard-container">
                @include('livewire.account.partials.sidebar', [
                    'active' => 'achievements',
                    'mobileLabel' => 'Мої досягнення',
                    'mobileIcon' => 'account_assets/images/nav-link-icon-4-active.svg',
                ])

                <div class="dashboard-right my-achievements__right">
                    <section class="achievement">
                        <div class="achievement-balance">Ваш баланс: {{ $balance }} балів</div>

                        <div class="achievement-levels swiper">
                            <div class="swiper-wrapper">
                                @foreach ($levels as $index => $level)
                                    @php
                                        $claim = $claims->get($level->id);
                                        $available = $balance >= $level->points_required;
                                        $fallback = 'account_assets/images/slide-' . min($index + 1, 4) . '.png';
                                    @endphp
                                    <div class="achievement-level swiper-slide {{ $available ? 'is-complete' : '' }}" wire:key="achievement-level-{{ $level->id }}">
                                        <img src="{{ $level->image ? asset('storage/' . $level->image) : asset($fallback) }}" alt="{{ $level->title }}">
                                        @if ($available)
                                            <b>{{ $level->points_required }} балів</b>
                                        @endif

                                        @if ($claim)
                                            <button type="button" wire:click="showClaim({{ $claim->id }})">Отриманий <span>›</span></button>
                                        @elseif ($available && $level->gifts->isNotEmpty())
                                            <button type="button" wire:click="openGifts({{ $level->id }})">Отримати подарунок <span>›</span></button>
                                        @elseif ($available)
                                            <button type="button" disabled>Подарунок готується <span>›</span></button>
                                        @else
                                            <button type="button" disabled>Поки закритий <span>›</span></button>
                                        @endif

                                        <i><img src="{{ asset('account_assets/images/white-check.svg') }}" alt=""></i>
                                        <p>{{ $level->points_required }} балів</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <h2>За що йде нарахування балів?</h2>
                        <div class="achievement-points">
                            @foreach ($actions as $action)
                                <article>
                                    <p>{{ $action->title }}</p>
                                    <strong>{{ $action->points }} балів</strong>
                                    @if ($action->icon)
                                        <img src="{{ asset('account_assets/images/' . $action->icon) }}" alt="">
                                    @endif
                                </article>
                            @endforeach
                        </div>

                    </section>
                </div>
            </div>
        </section>
    </main>

    @if ($showGiftsModal)
        <section class="achievement-popup achievement-gifts-modal is-open" aria-hidden="false">
            <div class="achievement-popup__backdrop" wire:click="closeModals"></div>
            <div class="achievement-popup__dialog">
                <button class="achievement-popup__close" type="button" wire:click="closeModals" aria-label="Закрити">
                    <img src="{{ asset('account_assets/images/close.svg') }}" alt="">
                </button>
                <p>Подарунок ваш!</p>
                <h2>Виберіть будь-який<br>з подарунків</h2>
                <div class="achievement-gifts">
                    @foreach ($modalGifts as $index => $gift)
                        <label class="{{ $selectedGiftId === $gift->id ? 'is-selected' : '' }}" wire:click="selectGift({{ $gift->id }})">
                            <img src="{{ $gift->image && str_starts_with($gift->image, 'account_assets/') ? asset($gift->image) : ($gift->image ? asset('storage/' . $gift->image) : asset('account_assets/images/modal-prize-' . (($index % 2) + 1) . '.png')) }}" alt="">
                            <span>{{ $gift->title }}</span>
                            <input type="radio" name="gift" value="{{ $gift->id }}" @checked($selectedGiftId === $gift->id)>
                            <em>Обрати</em>
                        </label>
                    @endforeach
                </div>
                <button class="main-btn achievement-claim" type="button" wire:click="claimGift" @disabled(! $selectedGiftId)>
                    Забрати подарунок
                </button>
            </div>
        </section>
    @endif

    @if ($showVoucherModal && $claimedGift)
        <section class="achievement-popup achievement-voucher-modal is-open" aria-hidden="false">
            <div class="achievement-popup__backdrop" wire:click="closeModals"></div>
            <div class="achievement-popup__dialog achievement-voucher">
                <button class="achievement-popup__close" type="button" wire:click="closeModals" aria-label="Закрити">
                    <img src="{{ asset('account_assets/images/close.svg') }}" alt="">
                </button>
                <h2>{{ $claimedGift->title_snapshot }}</h2>
                <img src="{{ asset('account_assets/images/achievement-gift-250.png') }}" alt="">
                <h3>Ваш промокод</h3>
                <div class="achievement-code">
                    <strong id="achievement-code-value">{{ $claimedGift->code_snapshot }}</strong>
                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('achievement-code-value').textContent)">
                        <img src="{{ asset('account_assets/images/copy.svg') }}" alt="Копіювати">
                    </button>
                    <small>
                        {{ $claimedGift->expires_at ? 'Дійсний до ' . $claimedGift->expires_at->format('d.m.Y') : 'Без обмеження строку' }}
                    </small>
                </div>
                @if ($claimedGift->gift?->description)
                    <p>{{ $claimedGift->gift->description }}</p>
                @endif
                @if ($claimedGift->gift?->gift_type === 'partner' && $claimedGift->gift?->partner_url)
                    <a href="{{ $claimedGift->gift->partner_url }}" target="_blank" rel="noopener noreferrer" class="main-btn">Перейти на сайт партнера</a>
                @else
                    <button class="main-btn" type="button" wire:click="closeModals">Готово</button>
                @endif
            </div>
        </section>
    @endif

    <script>
        const initAchievementLevels = () => {
            const element = document.querySelector('.achievement-levels');
            if (!element || !window.Swiper) return;
            if (element.swiper) element.swiper.destroy(true, true);
            new Swiper(element, { slidesPerView: 'auto', freeMode: true });
        };
        document.addEventListener('DOMContentLoaded', initAchievementLevels);
        document.addEventListener('livewire:init', () => {
            Livewire.on('achievement-modal-opened', () => document.body.style.overflow = 'hidden');
            Livewire.on('achievement-modal-closed', () => document.body.style.overflow = 'visible');
            Livewire.hook('morph.updated', () => setTimeout(initAchievementLevels, 0));
        });
    </script>
</div>
