<div class="site-dialog-root video-dialog-root" x-data="videoDialog()" x-show="open" x-cloak
    @open-video.window="show($event.detail)" @close-video.window="close()" @keydown.escape.window="close()" @keydown.window="trap($event)" :aria-hidden="!open">
    <div class="site-dialog-overlay" @click="close()"></div>
    <section class="video-dialog" role="dialog" aria-modal="true" aria-labelledby="video-dialog-title">
        <header class="site-dialog-header"><strong id="video-dialog-title" x-text="title"></strong><button type="button" x-ref="close" @click="close()" aria-label="{{ __('content.close') }}">×</button></header>
        <div class="video-dialog-player" :data-ratio="ratio"><template x-if="open"><iframe :src="url" :title="title" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe></template></div>
    </section>
</div>
