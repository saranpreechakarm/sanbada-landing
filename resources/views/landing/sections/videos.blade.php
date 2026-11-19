@if($videos->isNotEmpty())
<section id="videos" class="catalog-section videos-section" x-data>
    <div class="catalog-container">
        <div class="catalog-heading"><div><h2>{{ __('content.videos') }}</h2><p>{{ __('content.videos_intro') }}</p></div></div>
        <div class="videos-grid" tabindex="0" @keydown.arrow-right.prevent="$el.scrollBy({left:($el.firstElementChild?.getBoundingClientRect().width || 260)+16,behavior:'smooth'})" @keydown.arrow-left.prevent="$el.scrollBy({left:-(($el.firstElementChild?.getBoundingClientRect().width || 260)+16),behavior:'smooth'})" aria-label="{{ __('content.videos') }}">
            @foreach($videos as $video)
                <article class="video-story video-format-{{ $video->formatClass() }}" data-aspect-ratio="{{ $video->aspect_ratio ?: '16:9' }}">
                    <button type="button" class="video-card-cover" @click="$dispatch('open-video', { embed: @js(\App\Models\Video::embedUrl($video->url)), title: @js($video->localized('title')), ratio: @js($video->aspect_ratio ?: '16:9') })" aria-label="{{ __('content.play_video') }}: {{ $video->localized('title') }}">
                        @if($video->thumbnailUrl())<img src="{{ $video->thumbnailUrl() }}" alt="{{ $video->localized('title') }}" loading="lazy" decoding="async">@else<span class="video-cover-fallback">{{ $video->localized('title') }}</span>@endif
                        <span class="video-play-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m9 5 11 7-11 7Z"/></svg></span><span class="video-format-label">{{ $video->aspect_ratio ?: '16:9' }}</span>
                    </button>
                    <div class="video-story-info"><h3>{{ $video->localized('title') }}</h3>@if($video->localized('description'))<p>{{ $video->localized('description') }}</p>@endif
                        @if($video->project?->is_published)<a href="#project-{{ $video->project_id }}" @click="$dispatch('catalog-select', { category: @js($video->project->category), target: @js('project-'.$video->project_id) })">{{ $video->project->title }} ↗</a>@endif
                    </div>
                </article>
            @endforeach
        </div>
        @if($videos->count() > 1)<p class="carousel-hint">{{ __('content.swipe_more') }} →</p>@endif
    </div>
</section>
@endif
