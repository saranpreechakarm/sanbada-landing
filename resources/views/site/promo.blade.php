<section id="monthly-offer" class="mp-offer">
    <img src="{{ asset('assets/optimized/hero/beach-2084350_1920.webp') }}" alt="{{ $ru ? 'Пляж Камала на Пхукете' : 'Kamala Beach, Phuket' }}" width="1920" height="1280" loading="lazy" decoding="async">
    <div class="mp-offer-shade"></div>
    <div class="mp-container mp-offer-content">
        <div><p class="mp-eyebrow">{{ $ru ? 'Предложение месяца' : 'Offer of the Month' }}</p>
            <h2>{{ $ru ? 'Бесплатная консультация и варианты рассрочки 0%' : 'Free consultation and 0% instalment options' }}</h2>
            <p>{{ $ru ? 'Оставьте заявку — обсудим подходящие проекты и доступный график платежей.' : 'Leave a request to discuss suitable projects and available payment plans.' }}</p>
            <a href="#contacts" class="mp-button mp-offer-button btn-sweep">{{ $ru ? 'Узнать об акции' : 'Request this month’s offer' }} @include('site.icon', ['name' => 'arrow-up-right'])</a>
            <p class="mp-offer-terms">{{ $ru ? 'Уточните проект, срок рассрочки и действующие условия у консультанта.' : 'Ask our team to confirm the eligible project, instalment period and current terms.' }}</p>
        </div>
        <span class="mp-offer-location">{{ $ru ? 'Пляж Камала · Пхукет' : 'Kamala Beach · Phuket' }}</span>
    </div>
</section>
