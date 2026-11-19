{{-- One project-native line icon vocabulary; 18px, stroke 1.5. --}}
<svg class="mp-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
    @switch($name ?? 'arrow-up-right')
        @case('arrow-up-right')<path d="M7 17 17 7M7 7h10v10"/>@break
        @case('arrow-up')<path d="M12 19V5m-6 6 6-6 6 6"/>@break
        @case('arrow-left')<path d="M19 12H5m6-6-6 6 6 6"/>@break
        @case('arrow-right')<path d="M5 12h14m-6-6 6 6-6 6"/>@break
        @case('move-horizontal')<path d="M3 12h18M7 8l-4 4 4 4m10-8 4 4-4 4"/>@break
        @case('play')<path d="m8 5 11 7-11 7V5Z"/>@break
        @case('pause')<path d="M8 5v14M16 5v14"/>@break
        @case('home')<path d="m3 10 9-7 9 7v10H3V10Z"/><path d="M9 20v-8h6v8"/>@break
        @case('viewing')<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18m-12 5 2 2 4-4"/>@break
        @case('check')<path d="m5 12 4 4L19 6"/>@break
        @case('menu')<path d="M4 6h16M4 12h16M4 18h16"/>@break
        @case('x')<path d="m6 6 12 12M6 18 18 6"/>@break
        @case('plus')<path d="M12 5v14M5 12h14"/>@break
    @endswitch
</svg>
