import './bootstrap';
import Alpine from 'alpinejs';
import ownershipGallery from './ownership-gallery';

window.Alpine = Alpine;
window.ownershipGallery = ownershipGallery;

window.promoHero = () => ({
  inView: false,
  timer: null,

  animTitle: false,
  animZero: false,
  observer: null,

  init(el){
    el = el || this.$el;
    if (!el || this.observer) return;
    // สังเกตว่า section อยู่บนจอไหม
    const io = new IntersectionObserver(([entry]) => {
      this.inView = entry.isIntersecting;

      if (this.inView) {
        this.startLoop();
      } else {
        this.stopLoop();
        this.reset();
      }
    }, { threshold: 0.35 });

    this.observer = io;
    io.observe(el);
  },

  startLoop(){
    if (this.timer) return;

    // เล่นทันที 1 รอบตอนเข้าจอ
    this.playOnce();

    // เว้นระยะ 3 วินาทีต่อรอบ
    this.timer = setInterval(() => {
      if (this.inView) this.playOnce();
    }, 3000);
  },

  stopLoop(){
    if (!this.timer) return;
    clearInterval(this.timer);
    this.timer = null;
  },

  reset(){
    this.animTitle = false;
    this.animZero = false;
  },

  playOnce(){
    // รีเซ็ตก่อนเพื่อให้ animation ติดทุกครั้ง
    this.animTitle = false;
    this.animZero = false;

    requestAnimationFrame(() => {
      this.animTitle = true;
      this.animZero  = true;
    });
  },

  onSweepEnd(which, e){
    // เอาเฉพาะตอน sweep (::after) จบจริง ๆ
    // animationend จะยิงจาก element นี้ (ok)
    const el = e.target;

    // ใส่ pop แล้วถอดออก
    el.classList.add('is-pop');
    setTimeout(() => el.classList.remove('is-pop'), 550);

    // ปิดสถานะ is-anim เพื่อพร้อมรอบหน้า
    if (which === 'title') this.animTitle = false;
    if (which === 'zero')  this.animZero  = false;
  },
});

const viewportAnimations = document.querySelectorAll('.hero-zoom, .btn-sweep, .project-ribbon');

if ('IntersectionObserver' in window) {
  const motionObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      entry.target.classList.toggle('is-in-view', entry.isIntersecting);
    });
  }, {
    rootMargin: '150px 0px',
    threshold: 0.01,
  });

  viewportAnimations.forEach((element) => motionObserver.observe(element));
} else {
  viewportAnimations.forEach((element) => element.classList.add('is-in-view'));
}
function trapDialogFocus(event, root) {
  if (event.key !== 'Tab') return;
  const elements = Array.from(root.querySelectorAll('a[href],button,input,select,textarea,[tabindex="0"]')).filter(el => !el.disabled && el.getClientRects().length);
  const first = elements[0], last = elements[elements.length - 1];
  if (!first) return;
  if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
  else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
}

window.leadDialog = (seed = {}) => ({
  open: false, project: seed.project || null, projectId: seed.projectId || null, pdf: seed.pdf || null, submitting: false, previousFocus: null,
  init() { if (seed.hasErrors) this.show(seed); },
  show(detail = {}) {
    window.dispatchEvent(new CustomEvent('close-video'));
    this.previousFocus = document.activeElement;
    this.project = detail.project || null; this.projectId = detail.projectId || null; this.pdf = detail.pdf || null;
    this.open = true; this.submitting = false;
    document.documentElement.classList.add('site-dialog-open');
    this.$nextTick(() => this.$refs.phone.focus({ preventScroll: true }));
  },
  close() { if (!this.open) return; this.open = false; document.documentElement.classList.remove('site-dialog-open'); this.previousFocus?.focus({ preventScroll: true }); },
  trap(event) { if (this.open) trapDialogFocus(event, this.$root); },
});

window.videoDialog = () => ({
  open: false, url: '', title: '', ratio: '16:9', previousFocus: null,
  show(detail = {}) {
    if (!/^https:\/\/(?:www\.youtube-nocookie\.com\/embed\/[A-Za-z0-9_-]{11}|player\.vimeo\.com\/video\/[0-9]+(?:\?h=[a-f0-9]+)?)$/.test(detail.embed || '')) return;
    window.dispatchEvent(new CustomEvent('close-lead'));
    this.previousFocus = document.activeElement;
    const url = new URL(detail.embed); url.searchParams.set('autoplay', '1');
    this.url = url.toString(); this.title = detail.title || ''; this.ratio = ['16:9','9:16','1:1','4:5'].includes(detail.ratio) ? detail.ratio : '16:9';
    this.open = true; document.documentElement.classList.add('site-dialog-open');
    this.$nextTick(() => this.$refs.close.focus({ preventScroll: true }));
  },
  close() { if (!this.open) return; this.open = false; this.url = ''; document.documentElement.classList.remove('site-dialog-open'); this.previousFocus?.focus({ preventScroll: true }); },
  trap(event) { if (this.open) trapDialogFocus(event, this.$root); },
});

Alpine.start();
