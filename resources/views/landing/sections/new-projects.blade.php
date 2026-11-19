@if($newProjects->isNotEmpty())
<section id="new-projects" class="catalog-section new-projects-section" x-data>
    <div class="catalog-container">
        <div class="catalog-heading"><h2>{{ __('content.new_projects') }}</h2><a class="catalog-text-link" href="#projects">{{ __('content.explore_all') }} ↗</a></div>
        <div class="new-projects-grid" tabindex="0" @keydown.arrow-right.prevent="$el.scrollBy({left:($el.firstElementChild?.getBoundingClientRect().width || 260)+16,behavior:'smooth'})" @keydown.arrow-left.prevent="$el.scrollBy({left:-(($el.firstElementChild?.getBoundingClientRect().width || 260)+16),behavior:'smooth'})">
            @foreach($newProjects as $project)
                <a href="#project-{{ $project->id }}" class="new-project-card"
                    @click="$dispatch('catalog-select', { category: @js($project->category), target: @js('project-'.$project->id) })">
                    @if($project->images)<img src="{{ $project->imageUrls()[0] }}" alt="{{ $project->title }}" loading="lazy" decoding="async">@endif
                    @include('landing.partials.project-ribbon')
                    <div class="new-project-info"><h3>{{ $project->title }}</h3>@if($project->location)<p>{{ $project->location }}</p>@endif</div>
                </a>
            @endforeach
        </div>
        @if($newProjects->count() > 1)<p class="carousel-hint">{{ __('content.swipe_more') }} →</p>@endif
    </div>
</section>
@endif
