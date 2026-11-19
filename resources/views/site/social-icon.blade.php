<svg class="mp-social-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
    @switch($type)
        @case('facebook')<path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.51 1.5-3.9 3.79-3.9 1.1 0 2.25.2 2.25.2v2.47h-1.27c-1.25 0-1.64.78-1.64 1.57V12h2.79l-.45 2.89h-2.34v6.99A10 10 0 0 0 22 12Z"/>@break
        @case('telegram')<path d="m21.5 3.5-3.3 16c-.2 1.1-.9 1.4-1.8.9l-5-3.7-2.4 2.3c-.3.3-.5.5-1 .5l.4-5 9.2-8.3c.4-.4-.1-.6-.6-.3L5.6 13.1.7 11.5c-1.1-.4-1.2-1.1.2-1.7L20.1 2.5c.9-.3 1.7.2 1.4 1Z"/>@break
        @case('instagram')<rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="17.5" cy="6.5" r="1"/>@break
        @case('whatsapp')<path d="M12 2a10 10 0 0 0-8.5 15.3L2 22l4.8-1.5A10 10 0 1 0 12 2Zm5.6 14.3c-.2.6-1.3 1.2-1.8 1.2-.5.1-1.2.1-3.5-.8-2.9-1.2-4.8-4.2-4.9-4.4-.2-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.2-.2.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.1-.3.3-.1.6.2.3.7 1.1 1.5 1.8 1 .9 1.8 1.2 2.1 1.3.3.2.5.2.7-.1l.9-1.1c.2-.3.4-.2.7-.1l1.9.9c.3.1.5.2.6.4.1.1.1.7-.1 1.3Z"/>@break
    @endswitch
</svg>
