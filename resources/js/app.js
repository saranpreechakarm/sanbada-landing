import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.promoHero = () => ({
  inView: false,
  timer: null,

  animTitle: false,
  animZero: false,

  init(el){
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

Alpine.start();
