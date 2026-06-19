<div>
    <section class="modal data-modal {{ $showPassedModal ? 'active' : '' }}">
        <div class="modal-bg" wire:click="closePassedModal"></div>
        <div class="modal-dialog">
            <div class="container">
                <div class="modal-content">
                    <div class="modal-content__head">
                        <h2>Тест пройдено</h2>
                        <button type="button" class="modal-close" wire:click="closePassedModal">
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.19 11.37L1.44667 20.1133C1.29111 20.2689 1.1 20.3522 0.873333 20.3633C0.646666 20.3744 0.444444 20.2911 0.266666 20.1133C0.0888886 19.9356 0 19.7389 0 19.5233C0 19.3078 0.0888886 19.1111 0.266666 18.9333L9.01 10.19L0.266666 1.44667C0.111111 1.29111 0.0277774 1.1 0.0166663 0.873333C0.00555514 0.646666 0.0888886 0.444444 0.266666 0.266666C0.444444 0.0888886 0.641111 0 0.856667 0C1.07222 0 1.26889 0.0888886 1.44667 0.266666L10.19 9.01L18.9333 0.266666C19.0889 0.111111 19.2806 0.0277774 19.5083 0.0166663C19.7339 0.00555514 19.9356 0.0888886 20.1133 0.266666C20.2911 0.444444 20.38 0.641111 20.38 0.856667C20.38 1.07222 20.2911 1.26889 20.1133 1.44667L11.37 10.19L20.1133 18.9333C20.2689 19.0889 20.3522 19.2806 20.3633 19.5083C20.3744 19.7339 20.2911 19.9356 20.1133 20.1133C19.9356 20.2911 19.7389 20.38 19.5233 20.38C19.3078 20.38 19.1111 20.2911 18.9333 20.1133L10.19 11.37Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <div class="form-group">
                        <div class="text-value">Вітаємо! Ви успішно пройшли тестування.</div>
                        <div class="text-label">Ваш результат: {{ $scorePercent }}%</div>
                    </div>
                    <button type="button" wire:click="closePassedModal" class="main-btn">ОК</button>
                </div>
            </div>
        </div>
    </section>

    <section class="modal data-modal {{ $showDataModal ? 'active' : '' }}">
        <div class="modal-bg" wire:click="closeDataModal"></div>
        <div class="modal-dialog">
            <div class="container">
                <form wire:submit.prevent="saveAccountProfile" class="modal-content">
                    <div class="modal-content__head">
                        <h2>Редагувати дані</h2>
                        <button type="button" class="modal-close" wire:click="closeDataModal">
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.19 11.37L1.44667 20.1133C1.29111 20.2689 1.1 20.3522 0.873333 20.3633C0.646666 20.3744 0.444444 20.2911 0.266666 20.1133C0.0888886 19.9356 0 19.7389 0 19.5233C0 19.3078 0.0888886 19.1111 0.266666 18.9333L9.01 10.19L0.266666 1.44667C0.111111 1.29111 0.0277774 1.1 0.0166663 0.873333C0.00555514 0.646666 0.0888886 0.444444 0.266666 0.266666C0.444444 0.0888886 0.641111 0 0.856667 0C1.07222 0 1.26889 0.0888886 1.44667 0.266666L10.19 9.01L18.9333 0.266666C19.0889 0.111111 19.2806 0.0277774 19.5083 0.0166663C19.7339 0.00555514 19.9356 0.0888886 20.1133 0.266666C20.2911 0.444444 20.38 0.641111 20.38 0.856667C20.38 1.07222 20.2911 1.26889 20.1133 1.44667L11.37 10.19L20.1133 18.9333C20.2689 19.0889 20.3522 19.2806 20.3633 19.5083C20.3744 19.7339 20.2911 19.9356 20.1133 20.1133C19.9356 20.2911 19.7389 20.38 19.5233 20.38C19.3078 20.38 19.1111 20.2911 18.9333 20.1133L10.19 11.37Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <div class="form-group">
                        <input wire:model.defer="full_name" type="text" placeholder="Прізвище ім'я по-батькові" class="form-inp">
                        @error('full_name') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <input wire:model.defer="email" type="email" placeholder="Електронна пошта" class="form-inp">
                        @error('email') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <input wire:model.defer="phone" type="tel" placeholder="Номер телефону" class="form-inp">
                        @error('phone') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <div class="form-date">
                            <label>Ваша дата нарождення</label>
                            <div class="form-date__inp">
                                <input wire:model.defer="birth_day" type="text" placeholder="дд" maxlength="2">
                                <input wire:model.defer="birth_month" type="text" placeholder="мм" maxlength="2">
                                <input wire:model.defer="birth_year" type="text" placeholder="гггг" maxlength="4">
                            </div>
                        </div>
                        @error('birth_day') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                        @error('birth_month') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                        @error('birth_year') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <div class="row">
                            <input wire:model.defer="country" type="text" placeholder="Країна" class="form-inp">
                            <input wire:model.defer="city" type="text" placeholder="Місто" class="form-inp">
                        </div>
                        @error('country') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                        @error('city') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <input wire:model.defer="work_place" type="text" placeholder="Місце роботи" class="form-inp">
                        @error('work_place') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <input wire:model.defer="position" type="text" placeholder="Займана посада" class="form-inp">
                        @error('position') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                        <div class="form-radio">
                            @foreach ([
                                'Стоматологія',
                                'Терапевтична стоматологія',
                                'Ортопедична стоматологія',
                                'Хірургічна стоматологія',
                                'Дитяча стоматологія',
                                'Пародонтологія',
                                'Ортодонтія',
                                'Щелепно-лицева хірургія',
                            ] as $specialtyOption)
                                <div class="form-radio__item">
                                    <input wire:model.defer="specialty" type="radio" name="specialty" value="{{ $specialtyOption }}">
                                    <span>{{ $specialtyOption }}</span>
                                </div>
                            @endforeach
                        </div>
                        @error('specialty') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="main-btn">Зберегти</button>
                </form>
            </div>
        </div>
    </section>

    <main>
        <section class="webinar-data">
            <img src="{{ asset('account_assets/images/bg-1.png') }}" alt="" class="bg-1">
            <img src="{{ asset('account_assets/images/bg-2.png') }}" alt="" class="bg-2">
            <img src="{{ asset('account_assets/images/bg-1.png') }}" alt="" class="bg-3">
            <div class="container webinar-data__container">
                <div class="webinar-data__content">
                    @if ($selectedWebinar)
                        <div class="webinar-data__head">
                            <button type="button" wire:click="backToWebinars" class="webinar-data__back">Назад до вебінарів</button>
                            <h2>Оцінювання набутих знань учасників заходу "{{ $selectedWebinar->title }}"</h2>
                            <p>
                                Шановні учасники!<br>
                                Просимо уважно перевірити ваші дані та пройти тестування.<br>
                                Для успішного проходження тесту необхідно набрати не менше 80% правильних відповідей.<br>
                                Якщо результат нижчий, тест можна перездати.
                            </p>
                        </div>
                        <div class="webinar-data__body">
                            <div class="text">
                                <div class="text-label">Програма</div>
                                <div class="text-value">{{ $selectedWebinar->title }}</div>
                            </div>
                            <div class="text">
                                <div class="text-label">ПІБ</div>
                                <div class="text-value">{{ $full_name }}</div>
                            </div>
                            <div class="text">
                                <div class="text-label">Електронна пошта</div>
                                <a href="mailto:{{ $email }}" class="text-value">{{ $email }}</a>
                            </div>
                            <div class="text">
                                <div class="text-label">Ваш телефон</div>
                                <a href="tel:{{ $phone }}" class="text-value">{{ $phone }}</a>
                            </div>
                            <div class="text">
                                <div class="text-label">Дата народження</div>
                                <div class="text-value">{{ $birth_day && $birth_month && $birth_year ? $birth_day . '.' . $birth_month . '.' . $birth_year : 'Не вказано' }}</div>
                            </div>
                            <div class="text">
                                <div class="text-label">Країна / місто</div>
                                <div class="text-value">{{ trim($country . ', ' . $city, ', ') }}</div>
                            </div>
                            <div class="text">
                                <div class="text-label">Місце роботи</div>
                                <div class="text-value">{{ $work_place }}</div>
                            </div>
                            <div class="text">
                                <div class="text-label">Посада</div>
                                <div class="text-value">{{ $position }}</div>
                            </div>
                            <div class="text">
                                <div class="text-label">Спеціальність</div>
                                <ul class="text-alert">
                                    <li>{{ $specialty }}</li>
                                </ul>
                            </div>
                            <button type="button" wire:click="openDataModal" class="main-btn">Редагувати дані</button>
                        </div>

                        @unless ($isSubmitted && $isPassed)
                            <div class="question-list">
                                @foreach (($selectedWebinar->tests ?? []) as $questionIndex => $test)
                                    <div class="question-item" wire:key="test-question-{{ $selectedWebinar->id }}-{{ $questionIndex }}">
                                        <div class="question-text">
                                            <span>{{ $questionIndex + 1 }}.</span>
                                            <span>{{ $test['question'] ?? '' }}</span>
                                        </div>
                                        <ul class="question-answers">
                                            @foreach (($test['answers'] ?? []) as $answerIndex => $answer)
                                                <li wire:key="test-answer-{{ $selectedWebinar->id }}-{{ $questionIndex }}-{{ $answerIndex }}">
                                                    <input type="radio" wire:model="answers.{{ $questionIndex }}" name="answer-{{ $questionIndex }}" value="{{ $answerIndex }}">
                                                    <div class="icon"></div>
                                                    <p>{{ $answer['text'] ?? '' }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('answers.' . $questionIndex) <div class="form-label" style="color: #BD3333; margin-top: 12px;">{{ $message }}</div> @enderror
                                    </div>
                                @endforeach
                            </div>

                            @if ($isSubmitted && ! $isPassed)
                                <div class="webinar-data__result error">
                                    <h3>Тест не пройдено</h3>
                                    <p>Ваш результат: {{ $scorePercent }}%</p>
                                    <button type="button" wire:click="resetTestState" class="main-btn">Перездати</button>
                                </div>
                            @else
                                <button type="button" wire:click="submitTest" class="main-btn question-submit">Завершити тестування</button>
                            @endif
                        @endunless
                    @else
                        <section class="webinar">
                            <h2>Тестування</h2>
                            <div class="webinar-list">
                                @forelse ($testingWebinars as $webinar)
                                    <div class="webinar-card {{ $webinar->testing_is_open ? '' : 'lock' }}">
                                        <div class="card-head">
                                            <div class="card-top">
                                                <div class="card-top__text">
                                                    <span>{{ $webinar->testing_status_label }}</span>
                                                    <b class="countdown-display"
                                                        @if($webinar->testing_status_target_ts)
                                                            data-countdown-ts="{{ $webinar->testing_status_target_ts }}"
                                                            data-countdown-day-start-ts="{{ $webinar->testing_status_day_start_ts }}"
                                                            data-countdown-expired="{{ $webinar->testing_status_expired }}"
                                                        @endif
                                                    >{{ $webinar->testing_status_text }}</b>
                                                </div>
                                            </div>
                                            <div class="card-content">
                                                <img src="{{ asset('storage/' . $webinar->image) }}" alt="" class="main-img">
                                                <ul>
                                                    @if ($webinar->bpr_points)
                                                        <li>{{ $webinar->bpr_points }} балів БПР</li>
                                                    @endif
                                                    <li>{{ count($webinar->tests ?? []) }} питань</li>
                                                </ul>
                                                @if ($webinar->testing_is_open)
                                                    <a href="#" wire:click.prevent="selectWebinar({{ $webinar->id }})">
                                                        <img src="{{ asset('account_assets/images/arrow-up.svg') }}" alt="">
                                                    </a>
                                                @elseif ($webinar->test_is_passed)
                                                    <a href="{{ route('account.certificate') }}">
                                                        <img src="{{ asset('account_assets/images/arrow-up.svg') }}" alt="">
                                                    </a>
                                                @else
                                                    <button type="button">
                                                        <img src="{{ asset('account_assets/images/lock.svg') }}" alt="">
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-text">
                                            <h3>{{ $webinar->title }}</h3>
                                            <p>
                                                @if ($webinar->test_is_passed)
                                                    Тестування пройдено. Сертифікат доступний.
                                                @elseif ($webinar->testing_is_open)
                                                    Тестування доступне для проходження.
                                                @else
                                                    Тестування ще не відкрите або вже завершене.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="webinar-data__head">
                                        <h2>Тестування</h2>
                                        <p>Наразі у вас немає доступних тестів для проходження.</p>
                                    </div>
                                @endforelse
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </section>
    </main>
</div>
