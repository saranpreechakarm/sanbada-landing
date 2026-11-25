<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('seo.head')


  <link rel="icon" href="{{ asset('logo ขาวดำ.ico') }}">

  <style>[x-cloak] { display: none !important; }</style>

  <script src="{{ asset('js/site-c.js') }}?v={{ filemtime(public_path('js/site-c.js')) }}"></script>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/content-catalog.css') }}">


<link rel="stylesheet" href="{{ asset('css/marketing-site.css') }}">
<link rel="stylesheet" href="{{ asset('css/marketing-site-c.css') }}?v={{ filemtime(public_path('css/marketing-site-c.css')) }}">
</head>

<body class="sanbada-site mockup-c">

  @php($locale = app()->getLocale())
  @include('site.header')

  {{-- MAIN --}}
  @php($ru = $locale === 'ru')
  <main class="overflow-x-hidden site-main">
    @include('site-c.hero')
    @include('site.trust')
    @include('site-c.intent')
    @include('site-c.new-projects')
    @include('site-c.videos')
    @include('site-c.projects')
    @include('site.promo')
    @include('site.ownership-transfer')
    @include('site.team')
    @include('site-c.sales-gallery')
    @include('site.services')
    @include('site.submanee')
    @include('site.investment')
    @include('site.advantages')
    @include('site.faq')
    @include('site-c.contact')
  </main>

  @include('site.dialog')
  @include('site-c.offer')
  @include('site-c.lightbox')
  @include('landing.partials.video-dialog')
  @include('site-c.marquiz')



</body>

</html>
