@extends('properties.layout')
@section('content')
<div class="property-container property-section">
    <nav class="property-breadcrumb" aria-label="{{ $ru ? 'Путь к странице' : 'Breadcrumb' }}"><a href="{{ route('home', $locale) }}">{{ $ru ? 'Главная' : 'Home' }}</a><span aria-hidden="true">/</span><span>{{ $ru ? 'Проекты' : 'Projects' }}</span></nav>
    <h1>{{ explode(' | ', $seo['title'])[0] }}</h1>
    <p class="property-intro">{{ $ru ? 'Посмотрите фотографии, расположение и описание проектов. Уточните у нашей команды актуальные цены, наличие и условия просмотра.' : 'Explore project photos, locations and details. Ask our team for current prices, availability and viewing arrangements.' }}</p>
    <nav class="property-categories" aria-label="{{ $ru ? 'Тип недвижимости' : 'Property type' }}">
        @foreach(['properties.index' => $ru ? 'Все проекты' : 'All projects', 'properties.condos' => $ru ? 'Кондоминиумы' : 'Condominiums', 'properties.villas' => $ru ? 'Виллы' : 'Villas'] as $route => $label)
        <a href="{{ route($route, $locale) }}" @if(request()->routeIs($route)) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
    </nav>
    <div class="property-grid">
        @forelse($projects as $listing)
        <article class="property-card">
            <a href="{{ app(\App\Support\Seo::class)->projectPath($listing) }}">
                @if($listing->images)<img src="{{ $listing->imageUrls()[0] }}" alt="{{ $listing->title }}{{ $listing->location ? ' — '.$listing->location : '' }}" width="720" height="480" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async" @if($loop->first) fetchpriority="high" @endif>@endif
                <div><p class="property-meta">{{ $listing->category === 'villa' ? ($ru ? 'Вилла' : 'Villa') : ($ru ? 'Кондоминиум' : 'Condominium') }}@if($listing->location) · {{ $listing->location }}@endif</p><h2>{{ $listing->title }}</h2><p class="property-price">{{ $listing->localized('price') }}</p><p>{{ $listing->localized('badge') }}</p><span class="property-link">{{ $ru ? 'Смотреть проект' : 'View project' }} <span aria-hidden="true">→</span></span></div>
            </a>
        </article>
        @empty<p>{{ $ru ? 'Сейчас нет опубликованных проектов. Свяжитесь с нами для индивидуальной подборки.' : 'There are no published projects in this category yet. Contact us for a personal shortlist.' }}</p>@endforelse
    </div>
    @if($projects->hasPages())<div class="property-pagination">{{ $projects->links() }}</div>@endif
</div>
@endsection
