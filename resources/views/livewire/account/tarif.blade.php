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
                                <input type="number" placeholder="гг" maxlength="4">
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
                    'active' => 'tarif',
                    'mobileLabel' => 'Пакетні пропозиції',
                    'mobileIcon' => 'account_assets/images/nav-link-icon-5-active.svg',
                ])
                <div class="dashboard-right">
                    <section class="tarif">
                        <h2>Серія вебінарів</h2>
                        <ul class="tarif-navs">
                            <li>
                                <a href="#">Стоматологія</a>
                            </li>
                            <li>
                                <a href="#" class="active">Хірургічна стоматологія</a>
                            </li>
                            <li>
                                <a href="#">Терапевтична стоматологія</a>
                            </li>
                            <li>
                                <a href="#">Ортопедична стоматологія</a>
                            </li>
                            <li>
                                <a href="#">Дитяча стоматологія</a>
                            </li>
                            <li>
                                <a href="#">Пародонтологія</a>
                            </li>
                            <li>
                                <a href="#">Ортодонтія</a>
                            </li>
                            <li>
                                <a href="#">Щелепно-лицева хірургія</a>
                            </li>
                        </ul>
                        <div class="tarif-list">
                            <div class="tarif-card">
                                <div class="tarif-card__head">
                                    <div class="tarif-card__alert">
                                        <div class="tarif-card__alert-item">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.375 3.75V2.25M5.625 3.75V2.25M2.4375 6H15.5625M2.25 7.533C2.25 5.94675 2.25 5.15325 2.577 4.54725C2.87268 4.00673 3.3315 3.57338 3.888 3.309C4.53 3 5.37 3 7.05 3H10.95C12.63 3 13.47 3 14.112 3.309C14.6768 3.5805 15.135 4.014 15.423 4.5465C15.75 5.154 15.75 5.9475 15.75 7.53375V11.2177C15.75 12.804 15.75 13.5975 15.423 14.2035C15.1273 14.744 14.6685 15.1774 14.112 15.4418C13.47 15.75 12.63 15.75 10.95 15.75H7.05C5.37 15.75 4.53 15.75 3.888 15.441C3.33161 15.1768 2.87281 14.7437 2.577 14.2035C2.25 13.596 2.25 12.8025 2.25 11.2162V7.533Z" stroke="#3C3C3C" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>Вебинаров в серии</span>
                                        </div>
                                        <div class="tarif-card__alert-item bg-black">5 балів БПР</div>
                                    </div>
                                    <img src="{{ asset('account_assets/images/tarif-card-1.png') }}" alt="" class="main-img">
                                </div>
                                <div class="tarif-card__body">
                                    <h3>Місячний</h3>
                                    <div class="text">
                                        <ul>
                                            <li>
                                                <img src="{{ asset('account_assets/images/check-icon.svg') }}" alt="">
                                                <span>Доступ до 109 курсів в запису за напрямом (окрім комплексніх курсів)</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('account_assets/images/check-icon.svg') }}" alt="">
                                                <span>5 сертіфікатив з ьалами БПР кожного місяца</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('account_assets/images/check-icon.svg') }}" alt="">
                                                <span>Доступ до всіх майбутніх заходів за напрямом (окрім комплексніх курсів)</span>
                                            </li>
                                        </ul>
                                        <div class="alerts">
                                            <span>Лектор: Андрей Андреевич</span>
                                            <span>Лектор: Андрей Андреевич</span>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p>Скидка 50%</p>
                                        <del>1000 грн</del>
                                        <b>680 грн</b>
                                    </div>
                                    <a href="#" class="main-btn">Сплатити</a>
                                </div>
                            </div>
                            <div class="tarif-card">
                                <div class="tarif-card__head">
                                    <div class="tarif-card__alert">
                                        <div class="tarif-card__alert-item">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.375 3.75V2.25M5.625 3.75V2.25M2.4375 6H15.5625M2.25 7.533C2.25 5.94675 2.25 5.15325 2.577 4.54725C2.87268 4.00673 3.3315 3.57338 3.888 3.309C4.53 3 5.37 3 7.05 3H10.95C12.63 3 13.47 3 14.112 3.309C14.6768 3.5805 15.135 4.014 15.423 4.5465C15.75 5.154 15.75 5.9475 15.75 7.53375V11.2177C15.75 12.804 15.75 13.5975 15.423 14.2035C15.1273 14.744 14.6685 15.1774 14.112 15.4418C13.47 15.75 12.63 15.75 10.95 15.75H7.05C5.37 15.75 4.53 15.75 3.888 15.441C3.33161 15.1768 2.87281 14.7437 2.577 14.2035C2.25 13.596 2.25 12.8025 2.25 11.2162V7.533Z" stroke="#3C3C3C" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>Вебинаров в серии</span>
                                        </div>
                                        <div class="tarif-card__alert-item bg-black">5 балів БПР</div>
                                    </div>
                                    <img src="{{ asset('account_assets/images/tarif-card-2.png') }}" alt="" class="main-img">
                                </div>
                                <div class="tarif-card__body">
                                    <h3>Місячний</h3>
                                    <div class="text">
                                        <ul>
                                            <li>
                                                <img src="{{ asset('account_assets/images/check-icon.svg') }}" alt="">
                                                <span>Доступ до 109 курсів в запису за напрямом (окрім комплексніх курсів)</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('account_assets/images/check-icon.svg') }}" alt="">
                                                <span>5 сертіфікатив з ьалами БПР кожного місяца</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('account_assets/images/check-icon.svg') }}" alt="">
                                                <span>Доступ до всіх майбутніх заходів за напрямом (окрім комплексніх курсів)</span>
                                            </li>
                                        </ul>
                                        <div class="alerts">
                                            <span>Лектор: Андрей Андреевич</span>
                                            <span>Лектор: Андрей Андреевич</span>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p>Скидка 50%</p>
                                        <del>1000 грн</del>
                                        <b>680 грн</b>
                                    </div>
                                    <a href="#" class="main-btn">Сплатити</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
</div>
