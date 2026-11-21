@php($heroPhoto = $previewImage('assets/optimized/hero/hero-01.webp'))
<section class="c-hero" id="top">
    <div class="mp-container c-hero-grid">
        <div class="c-hero-copy">
            <p class="c-context">Sanbada Real Estate <span></span> Phuket, Thailand</p>
            <h1>{{ $ru ? 'Ваше место' : 'Your place' }}<br><span>{{ $ru ? 'на Пхукете' : 'in Phuket' }}</span></h1>
            <p class="c-hero-lead">{{ $ru ? 'Кондоминиумы и виллы — для вашей жизни, отдыха или следующей инвестиции.' : 'Condominiums and villas. For your life, your holidays, or your next investment.' }}</p>
            <p class="c-hero-note">{{ $ru ? 'Вы выбираете образ жизни. Мы помогаем найти подходящий проект.' : 'You choose the lifestyle. We help you find the right property.' }}</p>
            <div class="mp-hero-actions"><a href="#projects" class="mp-button mp-primary btn-sweep">{{ $ru ? 'Найти свой проект' : 'Find your property' }} @include('site-c.icon',['name'=>'arrow-up-right'])</a><a href="#videos" class="c-watch-link"><span>@include('site-c.icon',['name'=>'play'])</span>{{ $ru ? 'Смотреть видео' : 'Take a closer look' }}</a></div>
            <a href="#new-projects" class="c-scroll-cue">@include('site-c.icon',['name'=>'arrow-right']) {{ $ru ? 'Начните с новых проектов' : 'Start with what’s new' }}</a>
        </div>
        <div class="c-hero-photo"><img src="{{ $heroPhoto['large'] }}" srcset="{{ $heroPhoto['small'] }} 640w, {{ $heroPhoto['large'] }} 1280w" sizes="(max-width: 767px) 100vw, 55vw" width="800" height="850" fetchpriority="high" alt="{{ $ru ? 'Современная архитектура на Пхукете' : 'Contemporary architecture in Phuket' }}"><div class="c-hero-caption"><span>{{ $ru ? 'Жизнь ближе к морю' : 'A little closer to island life' }}</span><span>Phuket / Thailand</span></div><span class="c-photo-corner" aria-hidden="true"></span></div>
    </div>
</section>
