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
        @php($slides = $previewSlides($listing))
        <article class="property-card">
            <a class="property-card-link" href="{{ app(\App\Support\Seo::class)->projectPath($listing) }}" aria-labelledby="listing-{{ $listing->id }}">
                @if($slides)<img class="property-card-photo" src="{{ $slides[0]['small'] }}" srcset="{{ $slides[0]['small'] }} 640w, {{ $slides[0]['large'] }} 1280w" sizes="(min-width: 1024px) 380px, (min-width: 640px) 45vw, 90vw" alt="{{ $listing->title }}{{ $listing->location ? ' — '.$listing->location : '' }}" width="960" height="1280" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async" @if($loop->first) fetchpriority="high" @endif>@endif
                <div class="property-card-info">
                    <p class="property-meta">{{ $listing->category === 'villa' ? ($ru ? 'Вилла' : 'Villa') : ($ru ? 'Кондоминиум' : 'Condominium') }}@if($listing->location) · {{ $listing->location }}@endif</p>
                    <h2 id="listing-{{ $listing->id }}">{{ $listing->title }}</h2>
                    <p class="property-price">{{ $listing->localized('price') }}</p>
                    <p class="property-bedrooms">{{ $listing->localized('badge') }}</p>
                    <span class="property-link">{{ $ru ? 'Смотреть проект' : 'View project' }} @include('site-c.icon', ['name' => 'arrow-up-right'])</span>
                </div>
                @if($listing->is_new)@include('landing.partials.project-ribbon', ['project' => $listing])@endif
                @if($listing->is_featured)<span class="catalog-recommended"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.5 2.94 5.96 6.58.96-4.76 4.64 1.12 6.55L12 17.52l-5.88 3.09 1.12-6.55L2.48 9.42l6.58-.96Z"/></svg>{{ __('content.featured') }}</span>@endif
            </a>
        </article>
        @empty<p>{{ $ru ? 'Сейчас нет опубликованных проектов. Свяжитесь с нами для индивидуальной подборки.' : 'There are no published projects in this category yet. Contact us for a personal shortlist.' }}</p>@endforelse
    </div>
    @if($projects->hasPages())<div class="property-pagination">{{ $projects->links() }}</div>@endif
</div>
@endsection
