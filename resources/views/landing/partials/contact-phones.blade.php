<div class="contact-phone-list" style="display:flex;flex-direction:column;gap:8px">
    @foreach(config('contact.people') as $person)
        <a href="tel:{{ $person['phone'] }}" class="contact-phone-entry {{ $phoneLinkClass ?? '' }}"><span>{{ $person['display'] }}</span> <span>({{ $person['name'] }})</span>@if(($person['language'] ?? null) === 'ru')<small class="contact-phone-language" lang="ru" title="{{ app()->getLocale() === 'ru' ? 'Говорим по-русски' : 'Russian-speaking consultant' }}">Русский</small>@endif</a>
    @endforeach
</div>
