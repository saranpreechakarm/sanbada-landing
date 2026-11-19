@php($ru = $locale === 'ru')
<section class="mp-hero" id="top">
    <div class="mp-container mp-hero-grid">
        <div class="mp-hero-copy">
            <p class="mp-eyebrow">Sanbada Real Estate · Phuket, Thailand</p>
            <h1>{{ $ru ? 'Кондоминиумы и виллы на Пхукете' : 'Condominiums and villas in Phuket' }}</h1>
            <p class="mp-hero-intro">{{ $ru ? 'Для жизни, отдыха или инвестиций. Подберём варианты по вашему бюджету и району, поможем сравнить проекты и организовать просмотр.' : 'For living, holidays or investment. Find a shortlist for your budget and preferred area, with help comparing projects and arranging viewings.' }}</p>
            <div class="mp-hero-actions">
                <a href="#projects" class="mp-button mp-primary btn-sweep">{{ $ru ? 'Смотреть проекты' : 'Explore properties' }} <span aria-hidden="true">@include('site.icon', ['name' => 'arrow-up-right'])</span></a>
                <a href="#contacts" class="mp-button mp-secondary">{{ $ru ? 'Подобрать для меня' : 'Find my property' }}</a>
            </div>
        </div>
        <div class="mp-hero-visual">
            <img src="{{ asset('assets/optimized/hero/hero-01.webp') }}" alt="{{ $ru ? 'Современная архитектура на Пхукете' : 'Contemporary property architecture in Phuket' }}" width="800" height="850" fetchpriority="high" />
            <div class="mp-photo-caption"><span>{{ $ru ? 'Пхукет, Таиланд' : 'Phuket, Thailand' }}</span><strong>{{ $ru ? 'Архитектура для жизни у моря' : 'Architecture for island living' }}</strong></div>
        </div>
    </div>
</section>

