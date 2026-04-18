@php
    $active = $active ?? 'dashboard';
    $mobileLabel = $mobileLabel ?? 'Головна';
    $mobileIcon = $mobileIcon ?? 'account_assets/images/nav-link-icon-1-active.svg';
@endphp

<button class="dashboard-btn">
    <span class="dashboard-btn__left">
        <img src="{{ asset($mobileIcon) }}" alt="">
        <span>{{ $mobileLabel }}</span>
    </span>
    <img src="{{ asset('account_assets/images/nav-icon.svg') }}" alt="" class="icon">
</button>
<div class="dashboard-left">
    <ul class="dashboard-nav">
        <li>
            <a href="{{ route('account') }}" class="{{ $active === 'dashboard' ? 'active' : '' }}">
                <img src="{{ asset('account_assets/images/nav-link-icon-1-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-1.svg') }}" alt="">
                <span>Головна</span>
            </a>
        </li>
        <li>
            <a href="{{ route('account.certificate') }}" class="{{ $active === 'certificate' ? 'active' : '' }}">
                <img src="{{ asset('account_assets/images/nav-link-icon-2-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-2.svg') }}" alt="">
                <span>Мої сертифікати</span>
            </a>
        </li>
        <li>
            <a href="{{ route('account.webinar') }}" class="{{ $active === 'webinar' ? 'active' : '' }}">
                <img src="{{ asset('account_assets/images/nav-link-icon-3-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-3.svg') }}" alt="">
                <span>Вебінари у записі</span>
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('account_assets/images/nav-link-icon-4-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-4.svg') }}" alt="">
                <span>Мої досягнення</span>
            </a>
        </li>
        <li>
            <a href="{{ route('account.tarif') }}" class="{{ $active === 'tarif' ? 'active' : '' }}">
                <img src="{{ asset('account_assets/images/nav-link-icon-5-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-5.svg') }}" alt="">
                <span>Пакетні пропозиції</span>
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('account_assets/images/nav-link-icon-6-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-6.svg') }}" alt="">
                <span>Кейси</span>
            </a>
        </li>
        <li>
            <a href="{{ route('account.webinar-data') }}" class="{{ $active === 'testing' ? 'active' : '' }}">
                <img src="{{ asset('account_assets/images/nav-link-icon-7-active.svg') }}" alt="">
                <img src="{{ asset('account_assets/images/nav-link-icon-7.svg') }}" alt="">
                <span>Тестування</span>
            </a>
        </li>
    </ul>
</div>
