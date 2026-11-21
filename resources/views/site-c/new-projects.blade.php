@if($newProjects->isNotEmpty())
<section id="new-projects" class="c-new catalog-section" x-data="cRail()">
    <div class="catalog-container">
        <div class="c-section-heading"><div><p class="c-context">{{ $ru ? 'В центре внимания' : 'Worth a closer look' }}</p><h2>{{ $ru ? 'Новые проекты' : 'New projects' }}<span class="c-title-line" aria-hidden="true"></span></h2></div><div class="c-rail-actions"><span>{{ $ru ? 'Листайте и выбирайте' : 'A new perspective, every few seconds' }}</span><button type="button" @click="move(-1)" aria-label="{{ $ru ? 'Предыдущие проекты' : 'Previous new projects' }}">@include('site-c.icon',['name'=>'arrow-right'])</button><button type="button" @click="move(1)" aria-label="{{ $ru ? 'Следующие проекты' : 'Next new projects' }}">@include('site-c.icon',['name'=>'arrow-right'])</button></div></div>
        <div class="c-new-rail" x-ref="track" tabindex="0" @keydown.arrow-right.prevent="move(1)" @keydown.arrow-left.prevent="move(-1)" aria-label="{{ $ru ? 'Новые проекты' : 'New projects' }}">
            @foreach($newProjects as $project)
            @php($slides = array_values(array_intersect_key($previewSlides($project),array_flip([0,2,5]))))
            <article class="c-new-card" x-data="cGallery(@js($slides), true)" @mouseenter="paused=true" @mouseleave="paused=false" @focusin="focused=true" @focusout="focused=false">
                <span class="c-diagonal-wipe" aria-hidden="true"></span>
                <div class="c-photo-layers"><img src="{{ $slides[0]['small'] }}" :src="slots[0]" :class="{'c-photo-active':frontSlot===0}" alt="{{ $project->title }}" width="1280" height="960" loading="lazy" decoding="async"><img :src="slots[1] || null" :class="{'c-photo-active':frontSlot===1}" alt="" width="1280" height="960" decoding="async" aria-hidden="true"></div>
                <a href="#project-{{ $project->id }}" class="c-new-link" @click="$dispatch('catalog-select',{category:@js($project->category),target:@js('project-'.$project->id)})" aria-label="{{ $project->title }}"><span class="c-new-shade"></span><div class="c-new-info"><span class="c-new-location">@include('site-c.icon',['name'=>'map-pin']) {{ $project->catalogArea() ?: 'Phuket' }}</span><h3>{{ $project->title }}</h3><span class="c-open-project">@include('site-c.icon',['name'=>'arrow-up-right'])</span></div></a>
                @include('landing.partials.project-ribbon')
                <div class="c-story-bottom"><div class="c-story-progress" aria-hidden="true"><template x-for="(slide,i) in images" :key="i"><span><i :style="{transform:'scaleX('+(i<index?1:i===index?progress:0)+')'}"></i></span></template></div><button type="button" class="c-story-toggle" @click="pausedByUser=!pausedByUser" :aria-label="pausedByUser ? @js($ru ? 'Продолжить смену фото' : 'Play photo preview') : @js($ru ? 'Остановить смену фото' : 'Pause photo preview')" :aria-pressed="pausedByUser"><svg viewBox="0 0 20 20" aria-hidden="true"><path x-show="!pausedByUser" d="M7 5v10M13 5v10"/><path x-show="pausedByUser" d="m7 5 8 5-8 5Z"/></svg></button></div>
            </article>
            @endforeach
        </div>
        <div class="c-section-foot"><p>{{ $ru ? 'Понравился проект? Нажмите на фото, чтобы узнать больше.' : 'See something you like? Open the photo to explore the project.' }}</p><a href="#projects">{{ $ru ? 'Все проекты' : 'Explore the collection' }} @include('site-c.icon',['name'=>'arrow-up-right'])</a></div>
    </div>
</section>
@endif
