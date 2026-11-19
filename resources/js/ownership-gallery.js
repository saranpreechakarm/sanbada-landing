export default function ownershipGallery() {
    return {
        active: 1, count: 0, autoplay: true, hovered: false, focused: false, inView: false,
        direction: 1, cooldownUntil: 0, timer: null, observer: null, resizeObserver: null,
        motion: null, motionChanged: null, visibilityChanged: null, scrollFrame: null,
        init() {
            this.motion = window.matchMedia('(prefers-reduced-motion: reduce)');
            this.autoplay = !this.motion.matches;
            this.$nextTick(() => {
                this.count = this.$refs.track.children.length;
                this.go(Math.min(1, this.count - 1), false, false);
                this.observer = new IntersectionObserver(([entry]) => { this.inView = entry.isIntersecting; }, { threshold: 0.35 });
                this.observer.observe(this.$el);
                this.resizeObserver = new ResizeObserver(() => this.go(this.active, false, false));
                this.resizeObserver.observe(this.$refs.track);
                this.visibilityChanged = () => { this.cooldownUntil = Date.now() + 6000; };
                document.addEventListener('visibilitychange', this.visibilityChanged);
                this.motionChanged = () => { if (this.motion.matches) this.autoplay = false; };
                this.motion.addEventListener('change', this.motionChanged);
                this.timer = window.setInterval(() => {
                    if (!this.autoplay || !this.inView || this.hovered || this.focused || document.hidden || Date.now() < this.cooldownUntil || document.documentElement.classList.contains('site-dialog-open')) return;
                    if (this.active >= this.count - 1) this.direction = -1;
                    else if (this.active <= 0) this.direction = 1;
                    this.go(this.active + this.direction);
                }, 6000);
            });
        },
        interact() { this.cooldownUntil = Date.now() + 12000; },
        toggleAutoplay() { this.autoplay = !this.autoplay; if (this.autoplay) this.focused = false; this.cooldownUntil = Date.now() + 6000; },
        go(index, manual = false, animate = true) {
            const track = this.$refs.track;
            const next = Math.max(0, Math.min(this.count - 1, index));
            const slide = track?.children[next];
            if (!slide) return;
            if (manual) this.interact();
            this.active = next;
            const left = slide.offsetLeft - track.offsetLeft - (track.clientWidth - slide.offsetWidth) / 2;
            track.scrollTo({ left, behavior: animate && !this.motion.matches ? 'smooth' : 'instant' });
        },
        onScroll() {
            if (this.scrollFrame) return;
            this.scrollFrame = requestAnimationFrame(() => {
                this.scrollFrame = null;
                const track = this.$refs.track;
                const center = track.scrollLeft + track.clientWidth / 2;
                let nearest = 0, distance = Infinity;
                Array.from(track.children).forEach((slide, index) => {
                    const delta = Math.abs(slide.offsetLeft - track.offsetLeft + slide.offsetWidth / 2 - center);
                    if (delta < distance) { nearest = index; distance = delta; }
                });
                this.active = nearest;
            });
        },
        destroy() {
            clearInterval(this.timer); cancelAnimationFrame(this.scrollFrame);
            this.observer?.disconnect(); this.resizeObserver?.disconnect();
            document.removeEventListener('visibilitychange', this.visibilityChanged);
            this.motion?.removeEventListener('change', this.motionChanged);
        },
    };
}
