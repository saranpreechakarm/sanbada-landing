@extends('properties.layout')
@section('content')
@php($gallery = $project->imageUrls())
<article class="property-container property-section">
    <nav class="property-breadcrumb" aria-label="{{ $ru ? 'Путь к странице' : 'Breadcrumb' }}"><a href="{{ route('home', $locale) }}">{{ $ru ? 'Главная' : 'Home' }}</a><span aria-hidden="true">/</span><a href="{{ route('properties.index', $locale) }}">{{ $ru ? 'Проекты' : 'Projects' }}</a><span aria-hidden="true">/</span><span aria-current="page">{{ $project->title }}</span></nav>
    <div class="property-detail-grid">
        <div class="property-summary">
            <p class="property-meta">{{ $project->category === 'villa' ? ($ru ? 'Вилла' : 'Villa') : ($ru ? 'Кондоминиум' : 'Condominium') }}@if($project->location) · {{ $project->location }}@endif</p>
            <h1>{{ $project->title }}</h1>
            <p class="property-price">{{ $project->localized('price') }}</p>
            <p>{{ $project->localized('badge') }}</p>
            <button type="button" class="property-button btn-lux btn-sweep" x-data @click="$dispatch('open-lead', { projectId: @js($project->id), project: @js($project->title), pdf: @js($project->pdf_path) })">{{ $ru ? 'Уточнить наличие и цену' : 'Request availability & pricing' }}</button>
            <p class="property-note">{{ $ru ? 'Цены и наличие могут измениться. Запросите актуальную информацию по выбранному проекту.' : 'Prices and availability may change. Request the current details for this project.' }}</p>
        </div>
        @if($gallery)<img class="property-cover" src="{{ $gallery[0] }}" alt="{{ $project->title }}{{ $project->location ? ' — '.$project->location : '' }}" width="1200" height="800" fetchpriority="high" decoding="async">@endif
    </div>
    <section class="property-description" aria-labelledby="property-overview"><h2 id="property-overview">{{ $ru ? 'О проекте' : 'About this project' }}</h2>@foreach(preg_split('/\n\s*\n/', trim($project->localized('description'))) as $paragraph)<p>{{ trim($paragraph) }}</p>@endforeach</section>
    @if(count($gallery) > 1)<section aria-labelledby="property-gallery"><h2 id="property-gallery">{{ $ru ? 'Фотографии проекта' : 'Project gallery' }}</h2><div class="property-photo-grid">@foreach(array_slice($gallery, 1) as $image)<img src="{{ $image }}" alt="{{ $project->title }} — {{ $ru ? 'фото' : 'photo' }} {{ $loop->iteration + 1 }}" width="900" height="600" loading="lazy" decoding="async">@endforeach</div></section>@endif
    <p class="property-related"><a href="{{ route($project->category === 'villa' ? 'properties.villas' : 'properties.condos', $locale) }}">{{ $ru ? 'Другие проекты этого типа' : 'Explore more properties of this type' }} <span aria-hidden="true">→</span></a></p>
</article>
@endsection
