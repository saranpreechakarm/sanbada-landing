<div class="contact-phone-list" style="display:flex;flex-direction:column;gap:8px">
    @foreach(config('contact.people') as $person)
        <a href="tel:{{ $person['phone'] }}" @if(!empty($phoneLinkClass)) class="{{ $phoneLinkClass }}" @endif>{{ $person['display'] }} <span>({{ $person['name'] }})</span></a>
    @endforeach
</div>
