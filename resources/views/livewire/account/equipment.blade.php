<div class="equipment-page">
    <main>
        <section class="dashboard">
            <div class="dashboard-container">
                @include('livewire.account.partials.sidebar', [
                    'active' => 'equipment',
                    'mobileLabel' => 'Огляд обладнання',
                    'mobileIcon' => 'account_assets/images/nav-link-icon-7-active.svg',
                ])

                <div class="dashboard-right">
                    <section class="equipment">
                        <div class="equipment-head">
                            <div>
                                <h1>Огляд обладнання</h1>
                                <p>Огляд продукції різних брендів для сучасної стоматології</p>
                            </div>
                            <button class="equipment-action" type="button" wire:click="openProposalModal">
                                <span>+</span> Запропонувати огляд
                            </button>
                        </div>

                        @if ($submitted)
                            <div class="equipment-success">
                                Дякуємо! Огляд надіслано адміністратору та з'явиться після підтвердження.
                            </div>
                        @endif

                        <div class="equipment-banner">
                            <img src="{{ asset('account_assets/images/tish-bg.png') }}" alt="">
                            <p>
                                Надішліть посилання на ваш огляд,<br>
                                якщо ми його опублікуємо — нарахуємо<br>
                                вам у знак винагороди 50 балів
                            </p>
                            <strong>50 балів</strong>
                        </div>

                        <div class="equipment-list">
                            @forelse ($reviews as $item)
                                <article class="equipment-card" wire:key="equipment-review-{{ $item->id }}">
                                    <div class="equipment-card__media" wire:ignore>
                                        <video controls preload="metadata" wire:click="markViewed({{ $item->id }})" @if ($item->cover_url) poster="{{ $item->cover_url }}" @endif>
                                            <source src="{{ asset('storage/' . $item->video_file) }}">
                                        </video>
                                    </div>
                                    <h2>{{ $item->title }}</h2>
                                    <p>{{ $item->review }}</p>
                                </article>
                            @empty
                                <div class="equipment-empty">Підтверджених оглядів поки немає.</div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>

    @if ($showProposalModal)
        <section class="modal casey-modal tish-modal active" wire:key="equipment-proposal-modal">
            <div class="modal-bg" wire:click="closeProposalModal"></div>
            <div class="modal-dialog">
                <div class="container">
                    <form class="modal-content" wire:submit="submitProposal">
                        <div class="modal-content__head">
                            <h2>Запропонуйте огляд</h2>
                            <button type="button" class="modal-close" wire:click="closeProposalModal">
                                <img src="{{ asset('account_assets/images/close.svg') }}" alt="Закрити">
                            </button>
                        </div>

                        <div class="equipment-modal__banner equipment-banner">
                            <img src="{{ asset('account_assets/images/tish-bg.png') }}" alt="">
                            <div class="equipment-banner__shade"></div>
                            <p>
                                Надішліть посилання на ваш огляд. Якщо ми його опублікуємо — нарахуємо вам 50 балів.
                            </p>
                            <strong>50 балів</strong>
                        </div>

                        <div class="form-group">
                            <div class="equipment-phone">
                                <span>
                                    <img src="{{ asset('account_assets/images/ukraine.svg') }}" alt="">
                                </span>
                                <input wire:model="phone" type="tel" placeholder="+ 380" class="form-inp">
                            </div>
                            @error('phone') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <input wire:model="email" type="email" placeholder="Електронна пошта" class="form-inp">
                            @error('email') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <input wire:model="videoUrl" type="url" placeholder="Посилання на відео" class="form-inp">
                            @error('videoUrl') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <input wire:model="title" type="text" placeholder="Назва" class="form-inp">
                            @error('title') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <textarea wire:model="review" placeholder="Розгорнутий відгук" class="form-inp casey-modal__textarea"></textarea>
                            @error('review') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <label class="form-checkbox">
                                <span class="form-checkbox__icon">
                                    <input wire:model="confirmation" type="checkbox">
                                </span>
                                <span class="form-checkbox__text">
                                    Підтверджую, що маю право публікувати цей матеріал і погоджуюся на його розміщення на сайті.
                                </span>
                            </label>
                            @error('confirmation') <span class="casey-form__error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="main-btn" wire:loading.attr="disabled" wire:target="submitProposal">
                            Запропонувати
                        </button>
                    </form>
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('equipment-modal-opened', () => document.body.style.overflow = 'hidden');
            Livewire.on('equipment-modal-closed', () => document.body.style.overflow = 'visible');
        });
    </script>
</div>
