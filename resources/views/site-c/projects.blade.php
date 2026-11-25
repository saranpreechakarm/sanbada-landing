@php
    $projectFacts = $projects->map(function ($project) {
        return ['id' => $project->id, 'category' => $project->category, 'price' => $project->catalogPriceMillions(), 'area' => $project->catalogArea()];
    })->values();
    $catalogAreas = $projectFacts->pluck('area')->filter()->unique()->sort()->values();
@endphp
<section id="projects" class="catalog-section"
    x-data="cCatalog(@js($projectFacts))"
    @hashchange.window="selectFromHash()"
    @catalog-select.window="select($event.detail.category,$event.detail.target)">
    <div class="catalog-container">
        <div class="catalog-heading">
            <div><p class="mp-eyebrow">{{ $ru ? 'Кондоминиумы и виллы' : 'Condominiums and villas' }}</p><h2>{{ $ru ? 'Проекты' : 'Properties' }}</h2><p>{{ $ru ? 'Сравните варианты по бюджету и району' : 'Compare properties by budget and area' }}</p></div>
        </div>
        <div class="catalog-tabs" role="tablist" aria-label="{{ __('content.property_type') }}">
            @foreach(['condo' => ['condos', 'content.condos'], 'villa' => ['villas', 'content.villas']] as $value => [$panel, $label])
                <button type="button" role="tab" id="catalog-tab-{{ $value }}" aria-controls="{{ $panel }}"
                    :aria-selected="category === '{{ $value }}'" :class="{ 'active': category === '{{ $value }}' }"
                    @click="category = '{{ $value }}'"
                    @keydown.arrow-right.prevent="category = category === 'condo' ? 'villa' : 'condo'; $nextTick(() => document.getElementById('catalog-tab-' + category).focus())"
                    @keydown.arrow-left.prevent="category = category === 'condo' ? 'villa' : 'condo'; $nextTick(() => document.getElementById('catalog-tab-' + category).focus())">{{ __($label) }}</button>
            @endforeach
        </div>
        <div class="mp-filters">
            <label>{{ $ru ? 'Бюджет' : 'Budget' }}<select x-model="budget" aria-label="{{ $ru ? 'Бюджет' : 'Budget' }}"><option value="all">{{ $ru ? 'Любой бюджет' : 'Any budget' }}</option><option value="under5">{{ $ru ? 'До 5 млн ฿' : 'Under 5M THB' }}</option><option value="5to10">{{ $ru ? '5–10 млн ฿' : '5–10M THB' }}</option><option value="over10">{{ $ru ? 'От 10 млн ฿' : '10M+ THB' }}</option></select></label>
            <label>{{ $ru ? 'Район' : 'Area' }}<select x-model="area" aria-label="{{ $ru ? 'Район' : 'Area' }}"><option value="all">{{ $ru ? 'Все районы' : 'All areas' }}</option>@foreach($catalogAreas as $area)<option value="{{ $area }}">{{ $area }}</option>@endforeach</select></label>
            <p><strong x-text="Math.min(limit,visibleCount())"></strong> / <span x-text="visibleCount()"></span> {{ $ru ? 'подходящих вариантов' : 'matching properties' }}</p>
        </div>
        <p class="catalog-empty" x-show="!visibleCount()" x-cloak>{{ $ru ? 'В этой подборке нет совпадений. Измените фильтры или напишите нам — найдём другие варианты.' : 'No matches in this shortlist. Try another filter or ask us for more options.' }}</p>
        @foreach(['condo' => ['condos', 'content.condos'], 'villa' => ['villas', 'content.villas']] as $category => [$anchor, $heading])
            <div id="{{ $anchor }}" class="catalog-category" data-category="{{ $category }}" role="tabpanel"
                aria-labelledby="catalog-tab-{{ $category }}" x-show="category === '{{ $category }}'" x-cloak>
                <h3 class="catalog-accessible-title">{{ __($heading) }}</h3>
                <div class="catalog-list">
                    @forelse($projects->where('category', $category) as $project)
                        @php($galleryImages = $previewSlides($project))
                        @php($fact = $projectFacts->firstWhere('id', $project->id))
                        <article id="project-{{ $project->id }}" class="catalog-card" data-category="{{ $category }}" x-show="isVisible(@js($project->id))" tabindex="-1">
                            <div class="catalog-info">
                                <p class="catalog-bedroom">{{ $project->localized('badge') }}</p>
                                <h4><a href="{{ app(\App\Support\Seo::class)->projectPath($project) }}">{{ $project->title }}</a></h4>
                                @if($project->location)<p class="catalog-location">{{ $project->location }}</p>@endif
                                <p class="catalog-price">{{ $project->localized('price') }}</p>
                                <div class="catalog-description">
                                    @foreach(preg_split('/\n\s*\n/', trim($project->localized('description'))) as $paragraph)
                                        <p>{{ trim($paragraph) }}</p>
                                    @endforeach
                                </div>
                                <a class="catalog-cta btn-lux btn-sweep" href="{{ app(\App\Support\Seo::class)->projectPath($project) }}">{{ $ru ? 'Подробнее' : 'More details' }}</a>
                            </div>
                            <div class="catalog-gallery"
                                x-data="cGallery(@js($galleryImages))" @pointerenter="warmNext()"
                                @touchstart.passive="startX=$event.touches[0].clientX; startY=$event.touches[0].clientY"
                                @touchend="let dx=$event.changedTouches[0].clientX-startX; let dy=$event.changedTouches[0].clientY-startY; if(Math.abs(dx)>35 && Math.abs(dx)>Math.abs(dy)) { dx<0 ? next() : prev() }">
                                @if($project->images)<img src="{{ $galleryImages[0]['small'] }}" :src="slots[0]" :class="{'c-photo-active':frontSlot===0}" alt="{{ $project->title }}" width="1280" height="960" loading="lazy" decoding="async" draggable="false"><img :src="slots[1] || null" :class="{'c-photo-active':frontSlot===1}" alt="" width="1280" height="960" decoding="async" draggable="false" aria-hidden="true">@endif
                                <button type="button" class="c-photo-open" @click="expand(@js($project->title), $event.currentTarget)" aria-label="{{ $ru ? 'Открыть галерею' : 'Open photo gallery' }}: {{ $project->title }}"><span><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M8 3H3v5m13-5h5v5M3 16v5h5m13-5v5h-5"/></svg>{{ $ru ? 'Все фото' : 'View photos' }}</span></button>
                                <span class="c-photo-loading" x-show="waiting" x-cloak role="status">{{ $ru ? 'Загрузка фото' : 'Loading photo' }}</span>
                                @if($project->is_new)@include('landing.partials.project-ribbon')@endif
                                @if($project->is_featured)
                                    <span class="catalog-recommended"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.5 2.94 5.96 6.58.96-4.76 4.64 1.12 6.55L12 17.52l-5.88 3.09 1.12-6.55L2.48 9.42l6.58-.96Z"/></svg>{{ __('content.featured') }}</span>
                                @endif
                                @if(count($project->images ?? []) > 1)
                                    <button type="button" class="catalog-arrow prev" @click="prev()" aria-label="{{ __('content.previous_image') }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    <button type="button" class="catalog-arrow next" @click="next()" aria-label="{{ __('content.next_image') }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    <div class="catalog-gallery-footer"><div class="catalog-dots">
                                        <template x-for="(image, i) in images" :key="i"><button type="button" @click="go(i)" :class="{ 'active': index === i }" :aria-current="index === i ? 'true' : 'false'" :aria-label="@js(__('content.image')) + ' ' + (i+1)"></button></template>
                                    </div></div>
                                @endif
                            </div>
                        </article>
                    @empty<p class="catalog-empty">{{ __('content.coming_soon') }}</p>@endforelse
                </div>
            </div>
        @endforeach
        <div class="c-more-properties" x-show="visibleCount()>5" x-cloak>
            <p role="status" aria-live="polite" aria-atomic="true" x-text="@js($ru ? 'Показано ' : 'Showing ') + Math.min(limit,visibleCount()) + @js($ru ? ' из ' : ' of ') + visibleCount() + @js($ru ? ' проектов' : ' properties')"></p>
            <div class="c-more-actions"><button type="button" class="c-show-fewer" @click="fewer()" x-show="limit>5" x-cloak>{{ $ru ? 'Свернуть до 5' : 'Show fewer' }}</button><button type="button" class="mp-button c-view-more" @click="more()" x-show="limit<visibleCount()" :aria-controls="category==='condo'?'condos':'villas'"><span x-text="@js($ru ? 'Ещё ' : 'View ') + Math.min(5,visibleCount()-limit) + @js($ru ? ' проектов' : ' more properties')"></span>@include('site-c.icon',['name'=>'plus'])</button></div>
        </div>
        <div class="mp-catalog-help"><p>{{ $ru ? 'Не нашли свой вариант?' : 'Still looking for your perfect match?' }}</p><a href="#contacts" class="mp-text-link">{{ $ru ? 'Получить персональную подборку' : 'Get a personal shortlist' }} @include('site-c.icon', ['name' => 'arrow-up-right'])</a></div>
    </div>
</section>
