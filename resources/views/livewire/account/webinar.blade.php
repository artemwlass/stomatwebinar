<div>
    <section class="modal data-modal">
        <div class="modal-bg"></div>
        <div class="modal-dialog">
            <div class="container">
                <div class="modal-content">
                    <div class="modal-content__head">
                        <h2>Редагувати дані</h2>
                        <button class="modal-close">
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.19 11.37L1.44667 20.1133C1.29111 20.2689 1.1 20.3522 0.873333 20.3633C0.646666 20.3744 0.444444 20.2911 0.266666 20.1133C0.0888886 19.9356 0 19.7389 0 19.5233C0 19.3078 0.0888886 19.1111 0.266666 18.9333L9.01 10.19L0.266666 1.44667C0.111111 1.29111 0.0277774 1.1 0.0166663 0.873333C0.00555514 0.646666 0.0888886 0.444444 0.266666 0.266666C0.444444 0.0888886 0.641111 0 0.856667 0C1.07222 0 1.26889 0.0888886 1.44667 0.266666L10.19 9.01L18.9333 0.266666C19.0889 0.111111 19.2806 0.0277774 19.5083 0.0166663C19.7339 0.00555514 19.9356 0.0888886 20.1133 0.266666C20.2911 0.444444 20.38 0.641111 20.38 0.856667C20.38 1.07222 20.2911 1.26889 20.1133 1.44667L11.37 10.19L20.1133 18.9333C20.2689 19.0889 20.3522 19.2806 20.3633 19.5083C20.3744 19.7339 20.2911 19.9356 20.1133 20.1133C19.9356 20.2911 19.7389 20.38 19.5233 20.38C19.3078 20.38 19.1111 20.2911 18.9333 20.1133L10.19 11.37Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Прізвище ім'я по-батькові" class="form-inp">
                        <input type="email" placeholder="Електронна пошта" class="form-inp">
                        <input type="tel" placeholder="Номер телефону" class="form-inp">
                        <div class="form-date">
                            <label for="">Ваша дата нарождення</label>
                            <div class="form-date__inp">
                                <input type="number" placeholder="дд" maxlength="2">
                                <input type="number" placeholder="мм" maxlength="2">
                                <input type="number" placeholder="гггг" maxlength="4">
                            </div>
                        </div>
                        <input type="text" placeholder="Ваше місто" class="form-inp">
                        <select class="form-select">
                            <option value="Місце роботи" selected>Ваше місце роботи</option>
                            <option value="select-1">select 1</option>
                            <option value="select-2">select 2</option>
                            <option value="select-3">select 3</option>
                            <option value="select-4">select 4</option>
                            <option value="select-5">select 5</option>
                        </select>
                        <input type="text" placeholder="Ваша посада" class="form-inp">
                        <div class="form-radio">
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Терапевтична стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Ортопедична стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1" checked>
                                <span>Хірургічна стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Дитяча стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Пародонтологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Ортодонтія</span>
                            </div>
                            <div class="form-radio__item">
                                <input type="radio" name="radio1">
                                <span>Щелепно-лицева хірургія</span>
                            </div>
                        </div>
                    </div>
                    <button class="main-btn">Зберегти зміни</button>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="dashboard">
            <div class="dashboard-container">
                @include('livewire.account.partials.sidebar', [
                    'active' => 'webinar',
                    'mobileLabel' => 'Вебінари у записі',
                    'mobileIcon' => 'account_assets/images/nav-link-icon-3-active.svg',
                ])
                <div class="dashboard-right">
                    <section class="webinar">
                        <h2>Вебінари у записі</h2>
                        <div class="webinar-list">
                            @foreach ($webinars as $webinar)
                                <div class="webinar-card {{ $webinar->is_purchased ? '' : 'lock' }}">
                                    <div class="card-head">
                                        <div class="card-top">
                                            <div class="card-top__text">
                                                <span>{{ $webinar->webinar_status_label }}</span>
                                                <b class="countdown-display"
                                                    @if($webinar->webinar_status_target_ts)
                                                        data-countdown-ts="{{ $webinar->webinar_status_target_ts }}"
                                                        data-countdown-day-start-ts="{{ $webinar->webinar_status_day_start_ts }}"
                                                        data-countdown-expired="{{ $webinar->webinar_status_expired }}"
                                                    @endif
                                                >{{ $webinar->webinar_status_text }}</b>
                                            </div>
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
                                                @foreach ($webinar->display_lecturers as $lecturer)
                                                    <li>Лектор: {{ $lecturer }}</li>
                                                @endforeach
                                            </ul>
                                            <a href="{{ $webinar->is_purchased ? $webinar->video_url : $webinar->landing_url }}">
                                                <img src="{{ asset('account_assets/images/arrow-up.svg') }}" alt="">
                                            </a>
                                            @unless ($webinar->is_purchased)
                                                <button type="button">
                                                    <img src="{{ asset('account_assets/images/lock.svg') }}" alt="">
                                                </button>
                                            @endunless
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>{{ $webinar->title }}</h3>
                                        <p>Важливо: запис вебінару доступний 30 днів з моменту проведення вебінару</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
</div>
