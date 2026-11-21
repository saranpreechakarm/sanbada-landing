@php
    $seo = $seo ?? app(\App\Support\Seo::class)->home();
    $seoPublic = request()->routeIs('home', 'properties.*') && app(\App\Support\Seo::class)->canIndex();
@endphp
<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="robots" content="{{ $seoPublic ? 'index, follow, max-image-preview:large' : 'noindex, nofollow' }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">
@foreach($seo['alternates'] as $language => $alternate)
<link rel="alternate" hreflang="{{ $language }}" href="{{ $alternate }}">
@endforeach
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('seo.name') }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'ru' ? 'ru_RU' : 'en_US' }}">
<meta property="og:locale:alternate" content="{{ app()->getLocale() === 'ru' ? 'en_US' : 'ru_RU' }}">
<meta property="og:title" content="{{ $seo['title'] }}">
<meta property="og:description" content="{{ $seo['description'] }}">
<meta property="og:url" content="{{ $seo['canonical'] }}">
<meta property="og:image" content="{{ $seo['image'] }}">
<meta property="og:image:alt" content="{{ $seo['title'] }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo['title'] }}">
<meta name="twitter:description" content="{{ $seo['description'] }}">
<meta name="twitter:image" content="{{ $seo['image'] }}">
<script type="application/ld+json">{!! json_encode(['@'.'context' => 'https://schema.org', '@'.'graph' => $seo['schema']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) !!}</script>
