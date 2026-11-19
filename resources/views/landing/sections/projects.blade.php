<section id="projects" class="catalog-section"
    x-data="{
        category: 'condo',
        selectFromHash() {
            const target = document.getElementById(window.location.hash.slice(1));
            const selected = target?.dataset.category || target?.closest('[data-category]')?.dataset.category;
            if (selected) {
                this.category = selected;
                this.$nextTick(() => target.scrollIntoView({ block: 'start' }));
            }
        }
    }"
    x-init="$nextTick(() => selectFromHash())"
    @hashchange.window="selectFromHash()"
    @catalog-select.window="category = $event.detail.category; $nextTick(() => document.getElementById($event.detail.target)?.scrollIntoView({ behavior: 'smooth', block: 'start' }))">
    <div class="catalog-container">
        <div class="catalog-heading">
            <h2>{{ __('PROJECTS') }}</h2>
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
        @foreach(['condo' => ['condos', 'content.condos'], 'villa' => ['villas', 'content.villas']] as $category => [$anchor, $heading])
            <div id="{{ $anchor }}" class="catalog-category" data-category="{{ $category }}" role="tabpanel"
                aria-labelledby="catalog-tab-{{ $category }}" x-show="category === '{{ $category }}'" x-cloak>
                <h3 class="catalog-accessible-title">{{ __($heading) }}</h3>
                <div class="catalog-list">
                    @forelse($projects->where('category', $category) as $project)
                        @php($galleryImages = $project->imageUrls())
                        <article id="project-{{ $project->id }}" class="catalog-card" data-category="{{ $category }}">
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
                                <button type="button" class="catalog-cta btn-lux btn-sweep"
                                    @click="$dispatch('open-lead', { projectId: @js($project->id), project: @js($project->title), pdf: @js($project->pdf_path) })">{{ __('button_more_details') }}</button>
                            </div>
                            <div class="catalog-gallery"
                                x-data="{ images: @js($galleryImages), index: 0, startX: 0, startY: 0, next(){ if(this.images.length) this.index=(this.index+1)%this.images.length }, prev(){ if(this.images.length) this.index=(this.index-1+this.images.length)%this.images.length } }"
                                @touchstart.passive="startX=$event.touches[0].clientX; startY=$event.touches[0].clientY"
                                @touchend="let dx=$event.changedTouches[0].clientX-startX; let dy=$event.changedTouches[0].clientY-startY; if(Math.abs(dx)>35 && Math.abs(dx)>Math.abs(dy)) { dx<0 ? next() : prev() }">
                                @if($project->images)<img src="{{ $galleryImages[0] }}" :src="images[index]" alt="{{ $project->title }}" loading="lazy" decoding="async" draggable="false">@endif
                                @if($project->is_new)@include('landing.partials.project-ribbon')@endif
                                @if($project->is_featured)
                                    <span class="catalog-recommended"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.5 2.94 5.96 6.58.96-4.76 4.64 1.12 6.55L12 17.52l-5.88 3.09 1.12-6.55L2.48 9.42l6.58-.96Z"/></svg>{{ __('content.featured') }}</span>
                                @endif
                                @if(count($project->images ?? []) > 1)
                                    <button type="button" class="catalog-arrow prev" @click="prev()" aria-label="{{ __('content.previous_image') }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    <button type="button" class="catalog-arrow next" @click="next()" aria-label="{{ __('content.next_image') }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    <div class="catalog-gallery-footer"><div class="catalog-dots">
                                        <template x-for="(image, i) in images" :key="i"><button type="button" @click="index=i" :class="{ 'active': index === i }" :aria-current="index === i ? 'true' : 'false'" :aria-label="@js(__('content.image')) + ' ' + (i+1)"></button></template>
                                    </div></div>
                                @endif
                            </div>
                        </article>
                    @empty<p class="catalog-empty">{{ __('content.coming_soon') }}</p>@endforelse
                </div>
            </div>
        @endforeach
    </div>
</section>
