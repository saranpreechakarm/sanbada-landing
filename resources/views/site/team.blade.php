<section id="about" class="mp-section mp-team">
    <div class="mp-container mp-team-grid">
        <div class="mp-team-photo"><img src="{{ asset('assets/optimized/about/team.webp') }}" alt="Sanbada team" loading="lazy" width="700" height="500"><span>SANBADA REAL ESTATE</span></div>
        <div>
            <p class="mp-eyebrow">{{ $ru ? 'Команда Sanbada' : 'Your team in Phuket' }}</p>
            <h2>{{ $ru ? 'Помощь на каждом этапе покупки' : 'Local support, from shortlist to handover' }}</h2>
            <p class="mp-body">{{ $ru ? 'Расскажите, что для вас важно. Мы поможем сравнить проекты, организовать просмотры и разобраться в следующих шагах покупки.' : 'Tell us what matters to you. We will help you compare projects, arrange viewings and understand the next steps in your purchase.' }}</p>
            <a href="#contacts" class="mp-text-link">{{ $ru ? 'Познакомиться с консультантом' : 'Meet your property consultant' }} @include('site.icon', ['name' => 'arrow-up-right'])</a>

        </div>
    </div>
    <div class="mp-container mp-steps">
        @foreach($ru ? [['01','Ваши пожелания','Цель покупки, бюджет и любимые районы.'],['02','Личная подборка','Сравните подходящие проекты и планировки.'],['03','Просмотр','Посмотрите недвижимость вместе с нами.'],['04','Покупка и поддержка','Обсудите документы и дальнейшие шаги.']] : [['01','Your priorities','Share your goals, budget and favourite areas.'],['02','Your shortlist','Compare projects, layouts and locations.'],['03','Your viewing','Explore your preferred properties with us.'],['04','Your next steps','Discuss the purchase and ongoing support.']] as [$number,$title,$description])
            <div><span>{{ $number }}</span><h3>{{ $title }}</h3><p>{{ $description }}</p></div>
        @endforeach
    </div>
</section>



