<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('account_assets/scss/style.css') }}?v={{ filemtime(public_path('account_assets/scss/style.css')) }}">

</head>
<body>
<div class="wrapper">
    @include('livewire.account.partials.header', [
        'showTop' => $accountHeaderTop ?? true,
    ])

    {{ $slot }}

    <livewire:account.profile-modal />

    @include('livewire.account.partials.footer')
</div>

<script src="{{ asset('account_assets/js/iMask.js') }}?v={{ filemtime(public_path('account_assets/js/iMask.js')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('account_assets/js/main.js') }}?v={{ filemtime(public_path('account_assets/js/main.js')) }}"></script>
</body>
</html>
