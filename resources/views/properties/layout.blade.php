<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('seo.head')
    <link rel="icon" href="{{ asset('logo ขาวดำ.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/content-catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/property-pages.css') }}">
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="property-pages">
@php($ru = app()->getLocale() === 'ru')
@php($locale = app()->getLocale())
<a class="property-skip" href="#main-content">{{ $ru ? 'К содержанию' : 'Skip to content' }}</a>
<header class="property-header"><div class="property-container">
    <a href="{{ route('home', $locale) }}"><img src="{{ asset('assets/brand/logo-x-navbar.webp') }}" alt="Sanbada x Submanee Property" width="603" height="87"></a>
    <nav aria-label="{{ $ru ? 'Навигация' : 'Main navigation' }}">
        <a href="{{ route('properties.index', $locale) }}">{{ $ru ? 'Проекты' : 'Projects' }}</a>
        <a href="{{ route('home', $locale) }}#contacts">{{ $ru ? 'Контакты' : 'Contact us' }}</a>
        @foreach(['en' => 'EN', 'ru' => 'RU'] as $language => $label)
            <a href="{{ isset($project) ? app(\App\Support\Seo::class)->projectPath($project, $language) : route(request()->route()->getName(), ['locale' => $language, ...request()->only('page')], false) }}" lang="{{ $language }}" hreflang="{{ $language }}" @if($language === $locale) aria-current="true" @endif>{{ $label }}</a>
        @endforeach
    </nav>
</div></header>
<main id="main-content">@yield('content')</main>
<footer class="property-footer"><div class="property-container"><strong>Sanbada Real Estate</strong><p>Phuket Office · 27/18 Moo 2, Palai, T. Chalong, A. Muang Phuket, Phuket</p>@include('landing.partials.contact-phones')<p><a href="mailto:sanbadarus@gmail.com">sanbadarus@gmail.com</a></p><a href="{{ route('privacy', $locale) }}">{{ $ru ? 'Конфиденциальность' : 'Privacy policy' }}</a></div></footer>
@include('landing.partials.lead-dialog')
</body>
</html>
