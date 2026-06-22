@php
    $footerMenu1 = $site?->footer_menu1 ?? [];
    $footerMenu2 = $site?->footer_menu2 ?? [];
    $footerPhone = (string) ($site?->footer_phone ?? '');
    $footerPhoneHref = preg_replace('/[^\d+]/', '', $footerPhone);

    $socials = array_filter([
        ['url' => $site?->account_footer_facebook, 'icon' => 'account_assets/images/facebook.svg', 'label' => 'Facebook'],
        ['url' => $site?->account_footer_telegram, 'icon' => 'account_assets/images/tg.svg', 'label' => 'Telegram'],
        ['url' => $site?->account_footer_instagram, 'icon' => 'account_assets/images/insta.svg', 'label' => 'Instagram'],
        ['url' => $site?->account_footer_youtube, 'icon' => 'account_assets/images/youtube.svg', 'label' => 'YouTube'],
    ], fn (array $social) => filled($social['url']));
@endphp

<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="container footer-top__inner">
                <div class="footer-contact">
                    @if ($footerPhone)
                        <a href="tel:{{ $footerPhoneHref }}">{{ $footerPhone }}</a>
                    @endif
                    <span>Зворотний дзвінок</span>
                </div>

                <div class="footer-contact">
                    @if ($site?->footer_email)
                        <a href="mailto:{{ $site->footer_email }}">{{ $site->footer_email }}</a>
                    @endif
                    <span>Запитання та пропозиції</span>
                </div>

                @if ($socials)
                    <div class="footer-socials">
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset($social['icon']) }}" alt="{{ $social['label'] }}">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="container">
            <div class="footer-hr"></div>
        </div>

        <div class="container footer-mid">
            <div class="footer-logo-block">
                <a href="https://soco.com.ua" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('account_assets/images/footer-logo.svg') }}" alt="SOCO.COM.UA">
                </a>

                <div class="footer-payments footer-payments--mob">
                    <img src="{{ asset('account_assets/images/mastercard.svg') }}" alt="Mastercard">
                    <img src="{{ asset('account_assets/images/visacard.svg') }}" alt="VISA">
                </div>
            </div>

            <p class="footer-copy-mob">© {{ date('Y') }} stomatwebinar</p>

            <nav class="footer-nav">
                @foreach ([$footerMenu1, $footerMenu2] as $menu)
                    @if ($menu)
                        <ul>
                            @foreach ($menu as $item)
                                <li>
                                    <a href="{{ $item['link'] ?? '#' }}"
                                       @if (! empty($item['blanc'])) target="_blank" rel="noopener noreferrer" @endif>
                                        {{ $item['text'] ?? '' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </nav>

            <div class="footer-policy-mob">
                <a href="{{ route('politic') }}">Політика конфіденційності</a>
                <a href="{{ route('dogovor') }}">Договір публічної оферти</a>
            </div>
        </div>

        <div class="container footer-bottom">
            <span class="footer-copy">© {{ date('Y') }} stomatwebinar</span>

            <div class="footer-policy">
                <a href="{{ route('politic') }}">Політика конфіденційності</a>
                <a href="{{ route('dogovor') }}">Договір публічної оферти</a>
            </div>

            <div class="footer-payments footer-payments--desk">
                <img src="{{ asset('account_assets/images/mastercard.svg') }}" alt="Mastercard">
                <img src="{{ asset('account_assets/images/visacard.svg') }}" alt="VISA">
            </div>
        </div>
    </div>
</footer>
