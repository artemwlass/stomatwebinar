<div>
    <main>
        <section class="dashboard">
            <div class="dashboard-container">
                @include('livewire.account.partials.sidebar', [
                    'active' => 'cases',
                    'mobileLabel' => 'Кейси',
                    'mobileIcon' => 'account_assets/images/nav-link-icon-6-active.svg',
                ])

                <div class="dashboard-right">
                    <section class="casey">
                        <h2>Кейси</h2>

                        <div class="casey-header casey-header--publish-only">
                            <button type="button" class="main-btn casey-modal__open" wire:click="openPublishModal">
                                <img src="{{ asset('account_assets/images/plus.svg') }}" alt="">
                                Опублікувати кейс
                            </button>
                        </div>

                        <div class="dashboard-block">
                            <div class="card-list">
                                @forelse ($cases as $case)
                                    @php($preview = collect($case->media)->first())
                                    <a href="{{ route('account.cases.show', $case) }}" class="card" wire:key="clinical-case-{{ $case->id }}">
                                        <div class="card-head">
                                            @if ($preview && $case->isVideo($preview))
                                                <video class="main-img" muted preload="metadata">
                                                    <source src="{{ asset('storage/' . $preview) }}">
                                                </video>
                                            @elseif ($preview)
                                                <img src="{{ asset('storage/' . $preview) }}" alt="{{ $case->title }}" class="main-img">
                                            @else
                                                <img src="{{ asset('account_assets/images/card-1.png') }}" alt="{{ $case->title }}" class="main-img">
                                            @endif

                                            <div class="blue-badge">Автор: {{ $case->author_name }}</div>
                                            <div class="icon">
                                                <img src="{{ asset('account_assets/images/arrow-up.svg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h3>{{ $case->title }}</h3>
                                            <p>{{ \Illuminate\Support\Str::limit($case->complaints ?: $case->content, 150) }}</p>
                                            <span class="casey-card__meta">
                                                {{ $case->published_at?->locale('uk')->translatedFormat('d F Y') }}
                                                · {{ $case->comments_count }} коментарів
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <div class="casey-empty">Опублікованих кейсів поки немає. Станьте першим автором.</div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>

    @if ($showPublishModal)
        <section class="modal casey-modal active" wire:key="publish-case-modal">
            <div class="modal-bg" wire:click="closePublishModal"></div>
            <div class="modal-dialog">
                <div class="container">
                    <form class="modal-content" wire:submit="publish">
                        <div class="modal-content__head">
                            <h2>Опублікувати кейс</h2>
                            <button type="button" class="modal-close" wire:click="closePublishModal">
                                <img src="{{ asset('account_assets/images/close.svg') }}" alt="Закрити">
                            </button>
                        </div>

                        <div class="form-group">
                            <input wire:model="authorName" type="text" placeholder="Автор" class="form-inp">
                            @error('authorName') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <input wire:model="title" type="text" placeholder="Назва" class="form-inp">
                            @error('title') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <div class="row">
                                <input wire:model="gender" type="text" placeholder="Стать" class="form-inp">
                                <input wire:model="age" type="number" min="0" max="120" placeholder="Вік" class="form-inp">
                            </div>
                            @error('age') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <input wire:model="complaints" type="text" placeholder="Скарги" class="form-inp">
                            <input wire:model="medicalHistory" type="text" placeholder="Загальносоматичний анамнез" class="form-inp">
                            <input wire:model="examination" type="text" placeholder="Обстеження" class="form-inp">

                            <textarea wire:model="content" placeholder="Текст" class="form-inp casey-modal__textarea"></textarea>
                            @error('content') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <label class="casey-modal__upload">
                                <input wire:model="uploads" type="file" accept="image/*,video/*" multiple hidden>
                                <img src="{{ asset('account_assets/images/upload.svg') }}" alt="">
                                <span>Додати фото або відео</span>
                                @if (count($uploads))
                                    <small>Обрано файлів: {{ count($uploads) }}</small>
                                @endif
                            </label>
                            @error('uploads') <span class="casey-form__error">{{ $message }}</span> @enderror
                            @error('uploads.*') <span class="casey-form__error">{{ $message }}</span> @enderror

                            <div wire:loading wire:target="uploads" class="casey-uploading">Завантаження файлів...</div>

                            <label class="form-checkbox">
                                <span class="form-checkbox__icon">
                                    <input wire:model="confirmation" type="checkbox">
                                </span>
                                <span class="form-checkbox__text">
                                    Підтверджую, що маю право публікувати ці матеріали та не розкриваю персональні дані пацієнта.
                                </span>
                            </label>
                            @error('confirmation') <span class="casey-form__error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="main-btn" wire:loading.attr="disabled" wire:target="publish,uploads">
                            Опублікувати
                        </button>
                    </form>
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('case-modal-opened', () => document.body.style.overflow = 'hidden');
            Livewire.on('case-modal-closed', () => document.body.style.overflow = 'visible');
        });
    </script>
</div>
