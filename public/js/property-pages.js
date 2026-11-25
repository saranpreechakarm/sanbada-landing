/* Native scroll-snap gallery. No library or image requests until the images enter view. */
(() => {
  const reduced = () => matchMedia('(prefers-reduced-motion: reduce)').matches;
  window.propertyGallery = (images, title) => ({
    images, title, index: 0, frame: null, resizing: null,
    dragging: false, pointer: null, startX: 0, startScroll: 0, moved: false, suppressUntil: 0,
    init() {
      this.resizing = new ResizeObserver(() => this.queueSync());
      this.resizing.observe(this.$refs.track);
    },
    slides() { return [...this.$refs.track.querySelectorAll('.property-gallery-slide')]; },
    queueSync() {
      if (this.frame) return;
      this.frame = requestAnimationFrame(() => {
        this.frame = null;
        const slides = this.slides(), first = slides[0];
        if (!first) return;
        let nearest = 0, distance = Infinity;
        slides.forEach((slide, i) => {
          const delta = Math.abs(slide.offsetLeft - first.offsetLeft - this.$refs.track.scrollLeft);
          if (delta < distance) { distance = delta; nearest = i; }
        });
        this.index = nearest;
      });
    },
    go(next) {
      next = Math.max(0, Math.min(next, this.images.length - 1));
      const slides = this.slides();
      if (!slides[next]) return;
      this.$refs.track.scrollTo({left: slides[next].offsetLeft - slides[0].offsetLeft, behavior: reduced() ? 'instant' : 'smooth'});
    },
    move(direction) { this.go(this.index + direction); },
    dragStart(event) {
      if (event.pointerType !== 'mouse' || event.button !== 0) return;
      this.pointer = event.pointerId; this.startX = event.clientX;
      this.startScroll = this.$refs.track.scrollLeft; this.moved = false;
    },
    dragMove(event) {
      if (this.pointer !== event.pointerId) return;
      const delta = event.clientX - this.startX;
      if (Math.abs(delta) > 6) {
        this.dragging = true; this.moved = true;
        if (!this.$refs.track.hasPointerCapture(event.pointerId)) this.$refs.track.setPointerCapture(event.pointerId);
        event.preventDefault(); this.$refs.track.scrollLeft = this.startScroll - delta;
      }
    },
    dragEnd() {
      if (this.pointer === null) return;
      const moved = this.moved, pointer = this.pointer;
      this.pointer = null; this.dragging = false;
      if (this.$refs.track.hasPointerCapture(pointer)) this.$refs.track.releasePointerCapture(pointer);
      if (moved) { this.suppressUntil = performance.now() + 200; this.queueSync(); }
    },
    expand(index, event) {
      if (performance.now() < this.suppressUntil) { event.preventDefault(); return; }
      window.dispatchEvent(new CustomEvent('open-c-gallery', {detail: {
        images: this.images.map(image => image.large), index, title: this.title,
        trigger: event.currentTarget, rect: event.currentTarget.getBoundingClientRect().toJSON()
      }}));
    },
    destroy() { this.resizing?.disconnect(); cancelAnimationFrame(this.frame); }
  });
})();
