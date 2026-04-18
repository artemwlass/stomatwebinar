@php
    $showTop = $showTop ?? true;
@endphp

<header class="header">
    @if ($showTop)
        <div class="header-top">
            <div class="container header-top__container">
                <div class="header-top__text">
                    <img src="{{ asset('account_assets/images/fire.png') }}" width="16" alt="">
                    <p>Текст про ближайший вебинар 01.04.2026</p>
                </div>
                <a href="#">Ссылка на вебинар</a>
            </div>
        </div>
    @endif
    <div class="container header-container">
        <a href="/" class="header-logo">
            <img src="{{ asset('account_assets/images/logo.svg') }}" alt="">
            <img src="{{ asset('account_assets/images/logo-text.svg') }}" alt="">
        </a>
        <ul class="header-nav">
            <li>
                <a href="#">Найближчий вебінар</a>
            </li>
            <li>
                <a href="#">Купити все для ендо</a>
            </li>
            <li>
                <a href="#">Безкоштовні вебінари</a>
            </li>
            <li>
                <a href="#">Контакти</a>
            </li>
        </ul>
        <div class="header-right">
            <a href="#">
                <img src="{{ asset('account_assets/images/user-logo.svg') }}" alt="">
            </a>
            <button class="header-bars">
                <img src="{{ asset('account_assets/images/bars.svg') }}" alt="">
            </button>
        </div>
    </div>
</header>
