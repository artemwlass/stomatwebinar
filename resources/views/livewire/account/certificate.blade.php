<main>
    <section class="dashboard">
        <div class="dashboard-container">
            @include('livewire.account.partials.sidebar', [
                'active' => 'certificate',
                'mobileLabel' => 'Мої сертифікати',
                'mobileIcon' => 'account_assets/images/nav-link-icon-2-active.svg',
            ])

            <div class="dashboard-right">
                <section class="certificate">
                    <h2>Моє навчання</h2>
                    <div class="tab-head">
                        <button class="active">Мої сертифікати</button>
                        <button>Майбутні події</button>
                    </div>

                    <div class="tab-body active">
                        @forelse ($passedCertificates as $groupLabel => $certificates)
                            <div class="tab-body__item">
                                <h3>
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.375 3.75V2.25M5.625 3.75V2.25M2.4375 6H15.5625M2.25 7.533C2.25 5.94675 2.25 5.15325 2.577 4.54725C2.87268 4.00673 3.3315 3.57338 3.888 3.309C4.53 3 5.37 3 7.05 3H10.95C12.63 3 13.47 3 14.112 3.309C14.6768 3.5805 15.135 4.014 15.423 4.5465C15.75 5.154 15.75 5.9475 15.75 7.53375V11.2177C15.75 12.804 15.75 13.5975 15.423 14.2035C15.1273 14.744 14.6685 15.1774 14.112 15.4418C13.47 15.75 12.63 15.75 10.95 15.75H7.05C5.37 15.75 4.53 15.75 3.888 15.441C3.33161 15.1768 2.87281 14.7437 2.577 14.2035C2.25 13.596 2.25 12.8025 2.25 11.2162V7.533Z" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>{{ mb_convert_case($groupLabel, MB_CASE_TITLE, 'UTF-8') }}</span>
                                </h3>
                                <div class="content">
                                    @foreach ($certificates as $certificate)
                                        <div class="content-item">
                                            <div class="content-item__left">
                                                <p>{{ $certificate->webinar->title }} {{ $certificate->certificate_file_name }}</p>
                                                <ul>
                                                    @if ($certificate->webinar->bpr_points)
                                                        <li class="bg-blue">{{ $certificate->webinar->bpr_points }} балів БПР</li>
                                                    @endif
                                                    @foreach (($certificate->webinar->lecturers ?? []) as $lecturer)
                                                        @if (! empty($lecturer['name']))
                                                            <li>Лектор: {{ $lecturer['name'] }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <a href="#" class="content-item__right disabled">
                                                <img src="{{ asset('account_assets/images/doc-icon.svg') }}" alt="">
                                                <span>Завантажити (. PDF)</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="tab-body__item">
                                <div class="content">
                                    <div class="content-item">
                                        <div class="content-item__left">
                                            <p>У вас поки немає сертифікатів.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="tab-body">
                        @forelse ($futureCertificates as $groupLabel => $webinars)
                            <div class="tab-body__item">
                                <h3>
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.375 3.75V2.25M5.625 3.75V2.25M2.4375 6H15.5625M2.25 7.533C2.25 5.94675 2.25 5.15325 2.577 4.54725C2.87268 4.00673 3.3315 3.57338 3.888 3.309C4.53 3 5.37 3 7.05 3H10.95C12.63 3 13.47 3 14.112 3.309C14.6768 3.5805 15.135 4.014 15.423 4.5465C15.75 5.154 15.75 5.9475 15.75 7.53375V11.2177C15.75 12.804 15.75 13.5975 15.423 14.2035C15.1273 14.744 14.6685 15.1774 14.112 15.4418C13.47 15.75 12.63 15.75 10.95 15.75H7.05C5.37 15.75 4.53 15.75 3.888 15.441C3.33161 15.1768 2.87281 14.7437 2.577 14.2035C2.25 13.596 2.25 12.8025 2.25 11.2162V7.533Z" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>{{ mb_convert_case($groupLabel, MB_CASE_TITLE, 'UTF-8') }}</span>
                                </h3>
                                <div class="content">
                                    @foreach ($webinars as $webinar)
                                        <div class="content-item">
                                            <div class="content-item__left">
                                                <p>{{ $webinar->title }}</p>
                                                <ul>
                                                    @foreach (($webinar->lecturers ?? []) as $lecturer)
                                                        @if (! empty($lecturer['name']))
                                                            <li>Лектор: {{ $lecturer['name'] }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <a href="#" class="content-item__right disabled">
                                                <img src="{{ asset('account_assets/images/doc-icon.svg') }}" alt="">
                                                <span>Очікує отримання...</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="tab-body__item">
                                <div class="content">
                                    <div class="content-item">
                                        <div class="content-item__left">
                                            <p>Майбутніх сертифікатів поки немає.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>
