@if(in_array($name ?? '', ['map-pin','message-circle'],true))
<svg class="mp-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
@if($name === 'map-pin')<path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>
@else<path d="M21 11a9 9 0 0 1-9 9 9 9 0 0 1-4-.9L3 21l1.9-5A9 9 0 1 1 21 11Z"/>
@endif
</svg>
@else
@include('site.icon', ['name'=>$name ?? 'arrow-up-right'])
@endif
