@php
    $transferPhotos = ['IMG_6140.webp', 'IMG_7704.webp', 'IMG_7794.webp', 'IMG_7859.webp', 'IMG_8211.webp', 'S__7086088_0.webp'];
    $transferRu = $locale === 'ru';
@endphp
<section id="ownership-transfer" class="transfer-section" x-data="ownershipGallery()"
    aria-labelledby="transfer-heading" aria-roledescription="carousel"
    @focusin="focused = true" @focusout="focused = $el.contains($event.relatedTarget)">
    <div class="transfer-container">
        <div class="transfer-heading">
            <div>
                <p class="transfer-eyebrow">{{ $transferRu ? 'Наши клиенты' : 'Our clients' }}</p>
                <h2 id="transfer-heading">{{ $transferRu ? 'Фотогалерея' : 'Ownership transfer' }}</h2>
            </div>
            <p class="transfer-description">{{ $transferRu ? 'Фотографии успешной передачи права собственности нашим клиентам.' : 'A collection of successful property ownership transfers.' }}</p>
        </div>
    </div>
    <div class="transfer-window" @mouseenter="hovered = true" @mouseleave="hovered = false">
        <div id="transfer-track" class="transfer-track" x-ref="track" tabindex="0"
            aria-label="{{ $transferRu ? 'Фотографии клиентов. Используйте стрелки для просмотра.' : 'Client gallery. Use arrow keys to browse.' }}"
            @scroll.passive="onScroll()" @pointerdown="interact()" @wheel.passive="interact()"
            @keydown.right.prevent="go(active + 1, true)" @keydown.left.prevent="go(active - 1, true)"
            @keydown.home.prevent="go(0, true)" @keydown.end.prevent="go(count - 1, true)">
            @foreach($transferPhotos as $photo)
                <figure class="transfer-slide {{ $loop->index === 1 ? 'is-active' : '' }}"
                    :class="{ 'is-active': active === {{ $loop->index }} }"
                    role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} / {{ count($transferPhotos) }}">
                    <img src="{{ asset('img/optimized/'.$photo) }}"
                        alt="{{ $transferRu ? 'Передача недвижимости клиентам Sanbada' : 'Sanbada client property handover' }} — {{ $loop->iteration }}"
                        width="720" height="540" loading="lazy" decoding="async" draggable="false" />
                </figure>
            @endforeach
        </div>
    </div>
    <div class="transfer-container">
        <div class="transfer-footer">
            <p class="transfer-hint"><span aria-hidden="true">↔</span> {{ $transferRu ? 'Листайте, чтобы увидеть больше' : 'Swipe or use the arrows to explore' }}</p>
            <div class="transfer-controls">
                <button type="button" class="transfer-arrow" @click="go(active - 1, true)" :disabled="active === 0"
                    aria-controls="transfer-track" aria-label="{{ $transferRu ? 'Предыдущее фото' : 'Previous handover photo' }}">←</button>
                <div class="transfer-dots" aria-label="{{ $transferRu ? 'Выберите фото' : 'Choose a photo' }}">
                    @foreach($transferPhotos as $photo)
                        <button type="button" @click="go({{ $loop->index }}, true)"
                            :class="{ 'active': active === {{ $loop->index }} }" :aria-current="active === {{ $loop->index }} ? 'true' : 'false'"
                            aria-controls="transfer-track" aria-label="{{ $transferRu ? 'Фото' : 'Photo' }} {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
                <button type="button" class="transfer-arrow" @click="go(active + 1, true)" :disabled="active === count - 1"
                    aria-controls="transfer-track" aria-label="{{ $transferRu ? 'Следующее фото' : 'Next handover photo' }}">→</button>
                <button type="button" class="transfer-toggle" @click="toggleAutoplay()" :aria-pressed="autoplay.toString()"
                    :aria-label="autoplay ? @js($transferRu ? 'Остановить слайд-шоу' : 'Pause slideshow') : @js($transferRu ? 'Включить слайд-шоу' : 'Play slideshow')">
                    <span aria-hidden="true" x-text="autoplay ? 'Ⅱ' : '▶'">Ⅱ</span>
                </button>
            </div>
        </div>
    </div>
</section>
