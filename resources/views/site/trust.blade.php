<section class="mp-trust" aria-label="{{ $ru ? 'Наш подход' : 'Our approach' }}"><div class="mp-container mp-trust-grid">
    @foreach($ru ? [['home','Подбор под ваш бюджет','Кондоминиумы и виллы на Пхукете'],['viewing','Организация просмотров','От списка проектов до личного визита'],['check','Сопровождение покупки','Помощь на каждом этапе']] : [['home','Matched to your budget','Condominiums and villas in Phuket'],['viewing','Property viewings','From your shortlist to your first visit'],['check','Purchase support','Guidance throughout the process']] as [$icon,$title,$description])
        <div class="mp-trust-item"><span>@include('site.icon', ['name' => $icon])</span><div><strong>{{ $title }}</strong><p>{{ $description }}</p></div></div>
    @endforeach
</div></section>

