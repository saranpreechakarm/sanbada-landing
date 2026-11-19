<section id="faq" class="mp-section mp-faq"><div class="mp-container mp-faq-grid">
    <div><p class="mp-eyebrow">{{ $ru ? 'Покупка на Пхукете' : 'Buying in Phuket' }}</p><h2>{{ $ru ? 'Вопросы перед покупкой' : 'Questions before you buy' }}</h2><p class="mp-body">{{ $ru ? 'Не нашли свой вопрос? Напишите нам — обсудим вашу ситуацию лично.' : 'Have another question? Let us talk through your situation.' }}</p><a class="mp-text-link" href="#contacts">{{ $ru ? 'Задать вопрос' : 'Ask us a question' }} @include('site.icon', ['name' => 'arrow-up-right'])</a></div>
    <div class="mp-faq-items">
        @foreach($ru ? [['С чего начать подбор недвижимости?','Расскажите нам о цели покупки, бюджете и предпочтениях по району. Мы подготовим подходящие варианты для обсуждения.'],['Какие расходы учесть помимо цены объекта?','Запросите расчёт для выбранного проекта: дополнительные платежи и условия могут отличаться.'],['Можно ли организовать просмотр?','Оставьте запрос с интересующим проектом. Консультант обсудит удобное время и доступные варианты просмотра.'],['Кто поможет с вопросами документов?','На консультации обсудим документы и необходимые этапы. Юридические условия следует проверить для вашей ситуации.']] : [['How do I start finding a property?','Tell us your purpose, budget and preferred area. We will prepare options to discuss together.'],['What costs should I consider beyond the price?','Request a breakdown for your chosen project. Additional charges and conditions can vary.'],['Can I arrange a property viewing?','Leave a request with the project you like. A consultant will discuss suitable times and viewing options.'],['Who can help with documentation questions?','Discuss the documents and next steps with your consultant, including any legal review needed for your circumstances.']] as [$question,$answer])
            <details><summary>{{ $question }}<span>@include('site.icon', ['name' => 'plus'])</span></summary><p>{{ $answer }}</p></details>
        @endforeach
    </div>
</div></section>



