<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('seo.head')
    <link rel="icon" href="{{ asset('logo ขาวดำ.ico') }}">
    <script src="{{ asset('js/site-c.js') }}?v={{ filemtime(public_path('js/site-c.js')) }}"></script>
    <script src="{{ asset('js/property-pages.js') }}?v={{ filemtime(public_path('js/property-pages.js')) }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/content-catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/marketing-site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/marketing-site-c.css') }}?v={{ filemtime(public_path('css/marketing-site-c.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/property-pages.css') }}?v={{ filemtime(public_path('css/property-pages.css')) }}">
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="sanbada-site mockup-c property-pages" id="top">
@php($ru = app()->getLocale() === 'ru')
@php($locale = app()->getLocale())
<a class="property-skip" href="#main-content">{{ $ru ? 'К содержанию' : 'Skip to content' }}</a>
@include('site.header')
<main id="main-content">@yield('content')</main>
@include('site.footer')
@include('site.dialog')
@include('site-c.lightbox')
</body>
</html>
