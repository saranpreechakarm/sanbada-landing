<section class="c-hero c-hero-film" id="top" x-data="cHeroVideo()" @visibilitychange.document="sync()" @open-video.window="holdForDialog()" @open-lead.window="holdForDialog()">
    <div class="mp-container c-hero-grid">
        <div class="c-hero-copy">
            <p class="c-context">Sanbada Real Estate <span></span> Phuket, Thailand</p>
            <h1>{{ $ru ? 'Ваше место' : 'Your place' }}<br><span>{{ $ru ? 'на Пхукете' : 'in Phuket' }}</span></h1>
            <p class="c-hero-lead">{{ $ru ? 'Кондоминиумы и виллы — для вашей жизни, отдыха или следующей инвестиции.' : 'Condominiums and villas. For your life, your holidays, or your next investment.' }}</p>
            <p class="c-hero-note">{{ $ru ? 'Вы выбираете образ жизни. Мы помогаем найти подходящий проект.' : 'You choose the lifestyle. We help you find the right property.' }}</p>
            <div class="mp-hero-actions"><a href="#projects" class="mp-button mp-primary btn-sweep">{{ $ru ? 'Найти свой проект' : 'Find your property' }} @include('site-c.icon',['name'=>'arrow-up-right'])</a><button type="button" class="c-watch-link" @click="watch()"><span>@include('site-c.icon',['name'=>'play'])</span>{{ $ru ? 'Смотреть фильм' : 'Watch our film' }}</button></div>
            <a href="#new-projects" class="c-scroll-cue">@include('site-c.icon',['name'=>'arrow-right']) {{ $ru ? 'Начните с новых проектов' : 'Start with what’s new' }}</a>
        </div>
        <div class="c-hero-media">
            <div class="c-hero-player">
                <video id="hero-film" x-ref="film" autoplay muted playsinline loop controls preload="none" width="1280" height="720" poster="{{ asset('media/sanbada/sanbada-ru-poster-640.webp').'?v='.filemtime(public_path('media/sanbada/sanbada-ru-poster-640.webp')) }}" data-mobile-src="{{ url('/media/sanbada/480p.mp4').'?v='.filemtime(public_path('media/sanbada/sanbada-ru-480p.mp4')) }}" data-desktop-src="{{ url('/media/sanbada/720p.mp4').'?v='.filemtime(public_path('media/sanbada/sanbada-ru-720p.mp4')) }}" aria-label="{{ $ru ? 'Фильм Sanbada о Пхукете, на русском языке' : 'Sanbada film about Phuket, in Russian' }}" @play="onPlay()" @pause="onPause()" @loadeddata="loading=false" @waiting="loading=true" @playing="loading=false" @volumechange="muted=$refs.film.muted" x-on:error="failed=true;playing=false;loading=false">
                    <p>{{ $ru ? 'Ваш браузер не поддерживает видео.' : 'Your browser does not support video.' }} <a href="{{ url('/media/sanbada/720p.mp4').'?v='.filemtime(public_path('media/sanbada/sanbada-ru-720p.mp4')) }}">{{ $ru ? 'Открыть фильм' : 'Open the film' }}</a></p>
                </video>
                <button type="button" class="c-hero-play-fallback" x-show="!playing && !loading" x-cloak @click="resume()" aria-label="{{ $ru ? 'Воспроизвести фильм' : 'Play the film' }}">@include('site-c.icon',['name'=>'play'])</button>
            </div>
            <div class="c-hero-media-caption"><span>Sanbada / Phuket </span><button type="button" @click="toggleSound()" :aria-pressed="!muted"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="m11 4-6 5H2v6h3l6 5V4Z"/><path x-show="muted" d="m16 9 6 6m0-6-6 6"/><path x-show="!muted" d="M16 8a6 6 0 0 1 0 8m3-11a10 10 0 0 1 0 14"/></svg><span x-text="muted ? @js($ru ? 'Включить звук' : 'Enable sound') : @js($ru ? 'Выключить звук' : 'Mute sound')"></span></button></div>
            <p class="c-hero-video-error" role="status" x-show="failed" x-cloak>{{ $ru ? 'Не удалось загрузить видео.' : 'The video could not be loaded.' }} <a href="{{ url('/media/sanbada/720p.mp4').'?v='.filemtime(public_path('media/sanbada/sanbada-ru-720p.mp4')) }}">{{ $ru ? 'Открыть фильм' : 'Open the film' }}</a></p>
        </div>
    </div>
</section>
