@extends('properties.layout')
@section('content')
<article>
<div class="property-container property-section property-detail-section">
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
        @if($gallery)<img class="property-cover" src="{{ $gallery[0]['large'] }}" srcset="{{ $gallery[0]['small'] }} 640w, {{ $gallery[0]['large'] }} 1280w" sizes="(min-width: 768px) 55vw, 100vw" alt="{{ $project->title }}{{ $project->location ? ' — '.$project->location : '' }}" width="1200" height="800" fetchpriority="high" decoding="async">@endif
    </div>
    <section class="property-description" aria-labelledby="property-overview"><h2 id="property-overview">{{ $ru ? 'О проекте' : 'About this project' }}</h2>@foreach(preg_split('/\n\s*\n/', trim($project->localized('description'))) as $paragraph)<p>{{ trim($paragraph) }}</p>@endforeach</section>
</div>
    @if(count($gallery) > 1)
    <section class="property-gallery-section" x-data="propertyGallery(@js($gallery), @js($project->title))" aria-labelledby="property-gallery">
        <div class="property-container property-gallery-heading"><div><h2 id="property-gallery">{{ $ru ? 'Фотографии проекта' : 'Project gallery' }}</h2><p>{{ $ru ? 'Листайте фотографии. Нажмите, чтобы открыть на весь экран.' : 'Slide to explore. Select a photo for a closer look.' }}</p></div><div class="property-gallery-arrows"><button type="button" @click="move(-1)" :disabled="index===0" aria-label="{{ __('content.previous_image') }}">@include('site-c.icon', ['name' => 'arrow-right'])</button><button type="button" @click="move(1)" :disabled="index===images.length-1" aria-label="{{ __('content.next_image') }}">@include('site-c.icon', ['name' => 'arrow-right'])</button></div></div>
        <div class="property-gallery-track" x-ref="track" tabindex="0" role="region" aria-roledescription="carousel" aria-label="{{ $ru ? 'Фотографии проекта' : 'Project gallery' }}" @scroll.passive="queueSync()" @keydown.arrow-right.prevent="move(1)" @keydown.arrow-left.prevent="move(-1)" @keydown.home.prevent="go(0)" @keydown.end.prevent="go(images.length-1)" @pointerdown="dragStart($event)" @pointermove="dragMove($event)" @pointerup.window="dragEnd()" @pointercancel.window="dragEnd()" :class="{'is-dragging':dragging}">
            @foreach($gallery as $image)
            <button class="property-gallery-slide" type="button" @click="expand({{ $loop->index }}, $event)" aria-label="{{ $project->title }} — {{ $ru ? 'Открыть фото' : 'Open photo' }} {{ $loop->iteration }}">
                <img src="{{ $image['small'] }}" srcset="{{ $image['small'] }} 640w, {{ $image['large'] }} 1280w" sizes="(min-width: 768px) 42vw, 84vw" alt="{{ $project->title }} — {{ $ru ? 'фото' : 'photo' }} {{ $loop->iteration }}" width="1280" height="800" loading="lazy" decoding="async" draggable="false">
                <span class="property-photo-hint">@include('site-c.icon', ['name' => 'plus'])</span>
            </button>
            @endforeach
        </div>
        <div class="property-container property-gallery-footer"><p>{{ $ru ? 'Листайте или используйте стрелки' : 'Drag or use the arrows to explore' }}</p><div class="property-gallery-dots" aria-label="{{ $ru ? 'Выберите фото' : 'Choose a photo' }}">@foreach($gallery as $image)<button type="button" @click="go({{ $loop->index }})" :aria-current="index==={{ $loop->index }} ? 'true' : 'false'" aria-label="{{ __('content.image') }} {{ $loop->iteration }}"><span></span></button>@endforeach</div></div>
    </section>
    @endif
<div class="property-container">
    <p class="property-related"><a href="{{ route($project->category === 'villa' ? 'properties.villas' : 'properties.condos', $locale) }}">{{ $ru ? 'Другие проекты этого типа' : 'Explore more properties of this type' }} <span aria-hidden="true">→</span></a></p>
</div>
</article>
@endsection
