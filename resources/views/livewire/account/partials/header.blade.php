@php
    $showTop = $showTop ?? true;
    $accountPage = \App\Models\AccountPage::query()->first(['header_top_content', 'header_links']);
    $accountPageHeaderTopContent = trim((string) ($accountPage?->header_top_content ?? ''));
    $accountHeaderLinks = collect($accountPage?->header_links ?: [
        ['label' => 'Найближчий вебінар', 'url' => '/'],
        ['label' => 'Купити все для ендо', 'url' => '/'],
        ['label' => 'Безкоштовні вебінари', 'url' => '/'],
        ['label' => 'Контакти', 'url' => '/'],
    ])->filter(fn ($link) => filled($link['label'] ?? null) && filled($link['url'] ?? null))->take(4);
@endphp

<header class="header">
    @if ($showTop)
        <div class="header-top">
            <div class="container header-top__container">
                @if ($accountPageHeaderTopContent !== '')
                    <div class="header-top__text">
{{--                        <img src="{{ asset('account_assets/images/fire.png') }}" width="16" alt="">--}}
                        <div class="header-top__content">
                            {!! $accountPageHeaderTopContent !!}
                        </div>
                    </div>
                @else
                    <div class="header-top__text">
                        <img src="{{ asset('account_assets/images/fire.png') }}" width="16" alt="">
                        <p>Текст про ближайший вебинар 01.04.2026</p>
                    </div>
                    <a href="#">Ссылка на вебинар</a>
                @endif
            </div>
        </div>
    @endif
    <div class="container header-container">
        <a href="/" class="header-logo">
            <img src="{{ asset('account_assets/images/logo.svg') }}" alt="">
            <img src="{{ asset('account_assets/images/logo-text.svg') }}" alt="">
        </a>
        <ul class="header-nav">
            @foreach ($accountHeaderLinks as $link)
                <li>
                    <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                </li>
            @endforeach
        </ul>
        <div class="header-right">
            <div class="account-user-menu">
                <button type="button" class="account-user-menu__trigger" aria-label="Меню користувача">
                    <img src="{{ asset('account_assets/images/user-logo.svg') }}" alt="">
                </button>
                <div class="account-user-menu__dropdown">
                    <button type="button" onclick="Livewire.dispatch('open-account-profile-modal')">Редагувати</button>
                    <livewire:auth.logout />
                </div>
            </div>
            <button class="header-bars">
                <img src="{{ asset('account_assets/images/bars.svg') }}" alt="">
            </button>
        </div>
    </div>
</header>
