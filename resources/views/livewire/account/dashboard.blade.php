<main>
    <section class="modal certificate-modal {{ $showCertificateModal ? 'active' : '' }}">
        <div class="modal-bg"></div>
        <div class="modal-dialog">
            <div class="container">
                <form wire:submit.prevent="saveAccountProfile" class="modal-content">
                    <div class="modal-content__head">
                        <h2>Будь ласка, підтвердіть свої дані для коректної видачі сертифікатів</h2>
                        <button type="button" class="modal-close">
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
                            <label for="">Ваша дата нарождення</label>
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
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Стоматологія">
                                <span>Стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Терапевтична стоматологія">
                                <span>Терапевтична стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Ортопедична стоматологія">
                                <span>Ортопедична стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Хірургічна стоматологія">
                                <span>Хірургічна стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Дитяча стоматологія">
                                <span>Дитяча стоматологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Пародонтологія">
                                <span>Пародонтологія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Ортодонтія">
                                <span>Ортодонтія</span>
                            </div>
                            <div class="form-radio__item">
                                <input wire:model.defer="specialty" type="radio" name="specialty" value="Щелепно-лицева хірургія">
                                <span>Щелепно-лицева хірургія</span>
                            </div>
                        </div>
                        @error('specialty') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-checkbox">
                        <div class="form-checkbox__icon">
                            <input wire:model.defer="account_profile_confirmation" type="checkbox">
                        </div>
                        <div class="form-checkbox__text">Підтверджую, що Я УВАЖНО ознайомився(лася) з даною інструкцією з накладеними на ній правилами вебінару - *обов'язкове поле</div>
                    </div>
                    @error('account_profile_confirmation') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    <button type="submit" class="main-btn">Зберегти</button>
                </form>
            </div>
        </div>
    </section>

    <section class="dashboard">
        <div class="dashboard-container">
            @include('livewire.account.partials.sidebar', [
                'active' => 'dashboard',
                'mobileLabel' => 'Головна',
                'mobileIcon' => 'account_assets/images/nav-link-icon-1-active.svg',
            ])

            <div class="dashboard-right">
                <section class="dashboard-home">
                    <img src="{{ asset('account_assets/images/dashboard-home-card.png') }}" alt="" class="bg-img">
                    <div class="dashboard-home__head">
                        <h2>Вітаємо, {{ auth()->user()->name}}!</h2>
                        <p>Важливо: запис вебінару доступний 30 днів з моменту проведення вебінару</p>
                    </div>
                    <ul>
                        @foreach(($dashboardStats ?? []) as $stat)
                            <li>
                                <p>{{ $stat['label'] ?? 'Текст' }}</p>
                                <h3>{{ $stat['value'] ?? '' }}</h3>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="dashboard-block">
                    <h2>Найближчі заходи</h2>
                    <div class="card-list">
                        @foreach(($nearestWebinars ?? []) as $webinar)
                            <a href="{{ route('webinar.show', $webinar->slug) }}" class="card">
                                <div class="card-head">
                                    <img src="{{ asset('storage/' . $webinar->image) }}" alt="" class="main-img">
                                    <div class="card-alert">
                                        <div class="card-alert__item">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.375 3.75V2.25M5.625 3.75V2.25M2.4375 6H15.5625M2.25 7.533C2.25 5.94675 2.25 5.15325 2.577 4.54725C2.87268 4.00673 3.3315 3.57338 3.888 3.309C4.53 3 5.37 3 7.05 3H10.95C12.63 3 13.47 3 14.112 3.309C14.6768 3.5805 15.135 4.014 15.423 4.5465C15.75 5.154 15.75 5.9475 15.75 7.53375V11.2177C15.75 12.804 15.75 13.5975 15.423 14.2035C15.1273 14.744 14.6685 15.1774 14.112 15.4418C13.47 15.75 12.63 15.75 10.95 15.75H7.05C5.37 15.75 4.53 15.75 3.888 15.441C3.33161 15.1768 2.87281 14.7437 2.577 14.2035C2.25 13.596 2.25 12.8025 2.25 11.2162V7.533Z" stroke="#3C3C3C" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>{{ optional($webinar->date_preorder)->format('d.m.Y') }}</span>
                                        </div>
                                        @if ($webinar->bpr_points)
                                            <div class="card-alert__item">{{ $webinar->bpr_points }} балів БПР</div>
                                        @endif
                                    </div>
                                    <div class="icon">
                                        <img src="{{ asset('account_assets/images/arrow-up.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3>{{ $webinar->title }}</h3>
                                    <p>Важливо: запис вебінару доступний 30 днів з моменту проведення вебінару</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="dashboard-direction">
                    <div class="card">
                        <p>Мої досягнення</p>
                        <a href="{{ route('account.achievements') }}">Детальніше</a>
                        <img src="{{ asset('account_assets/images/direction-icon-1.png') }}" alt="">
                    </div>
                    <div class="card">
                        <p>Тестування</p>
                        <a href="{{ route('account.webinar-data') }}">Детальніше</a>
                        <img src="{{ asset('account_assets/images/direction-icon-2.png') }}" alt="">
                    </div>
                    <div class="card">
                        <p>Кейси</p>
                        <a href="{{ route('account.cases') }}">Детальніше</a>
                        <img src="{{ asset('account_assets/images/direction-icon-3.png') }}" alt="">
                    </div>
                    <div class="card">
                        <p>Пакетні пропозиції</p>
                        <a href="{{ route('account.tarif') }}">Детальніше</a>
                        <img src="{{ asset('account_assets/images/direction-icon-4.png') }}" alt="">
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>

@if ($showCertificateModal)
    <script>
        document.body.style.overflow = 'hidden';
    </script>
@endif

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('account-profile-confirmed', () => {
            document.body.style.overflow = 'visible';
            const modal = document.querySelector('.certificate-modal');

            if (modal) {
                modal.classList.remove('active');
            }
        });
    });
</script>
