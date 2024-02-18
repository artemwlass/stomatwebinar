<!DOCTYPE html>
<html lang="uk">
<head>
    <link rel="stylesheet" href="{{asset('assets/css/fonts.css')}}">

    <link rel="preload" as="font" type="font/woff2" crossorigin="anonymous"
          href="{{asset('assets/fonts/Geologica-Medium.woff2')}}">
    <link rel="preload" as="font" type="font/woff2" crossorigin="anonymous"
          href="{{asset('assets/fonts/Geologica-Regular.woff2')}}">
    <link rel="preload" as="font" type="font/woff2" crossorigin="anonymous"
          href="{{asset('assets/fonts/Geologica-Black.woff2')}}">
    <link rel="preload" as="font" type="font/woff2" crossorigin="anonymous"
          href="{{asset('assets/fonts/Geologica-ExtraLight.woff2')}}">
    <link rel="preload" as="font" type="font/woff2" crossorigin="anonymous"
          href="{{asset('assets/fonts/Geologica-Light.woff2')}}">
    <link rel="preload" as="font" type="font/woff2" crossorigin="anonymous"
          href="{{asset('assets/fonts/Geologica-Thin.woff2')}}">

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

{{--    {!! SEO::generate() !!}--}}

    <!-- Favicon for modern browsers -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{'assets/favicon/favicon-32x32.png'}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{'assets/favicon/favicon-16x16.png'}}">

    <!-- Favicon for Safari on iOS devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-touch-icon.png')}}">

    <!-- Favicon for Android Chrome -->
    <link rel="manifest" href="{{asset('assets/favicon/site.webmanifest')}}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{asset('assets/favicon/android-chrome-512x512.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/favicon/android-chrome-192x192.png')}}">

    <!-- Подключение Bootstrap5 -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Подключение стилей -->
{{--    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">--}}

</head>
<body>

{{$slot}}


</body>
</html>

