    {{-- PROJECTS (match new layout: text left, image right + blue arrows, no WhatsApp) --}}
    <section id="projects" class="bg-[#f3f4f6] text-[#111] scroll-mt-24">
      <div class="max-w-6xl mx-auto px-4 py-16">

        <h2 class="text-3xl md:text-4xl font-extrabold tracking-wide text-[#2b2b2b]">
          {{ __('PROJECTS') }}
        </h2>

        @php
        $projects = [
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'BALCONY Naiyang',
        'price_key' => 'projects.price_balcony',
        'desc_key' => 'projects.desc_balcony',
        'pdf' => 'assets/projects/pdf/13 The Balcony Naiyang.pdf',
        'images' => [
        'balcony-naiyang/1.jpg',
        'balcony-naiyang/2.jpg',
        'balcony-naiyang/3.jpg',
        'balcony-naiyang/4.jpg',
        'balcony-naiyang/5.jpg',
        'balcony-naiyang/6.jpg',
        'balcony-naiyang/7.jpg',
        'balcony-naiyang/8.jpg',
        'balcony-naiyang/9.jpg',
        'balcony-naiyang/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'VIBE RESIDENCE Karon',
        'price_key' => 'projects.price_vibe-karon',
        'desc_key' => 'projects.desc_vibe-karon',
        'pdf' => 'assets/projects/pdf/19 Vibe Residence Karon.pdf',
        'images' => [
        'vibe-karon/1.jpg',
        'vibe-karon/2.jpg',
        'vibe-karon/3.jpg',
        'vibe-karon/4.jpg',
        'vibe-karon/5.jpg',
        'vibe-karon/6.jpg',
        'vibe-karon/7.jpg',
        'vibe-karon/8.jpg',
        'vibe-karon/9.jpg',
        'vibe-karon/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'HALO 1 Naiyang',
        'price_key' => 'projects.price_halo_1_naiyang',
        'desc_key' => 'projects.desc_halo_1_naiyang',
        'pdf' => 'assets/projects/pdf/1 HALO 1 Naiyang.pdf',
        'images' => [
        'HALO-Naiyang/1.jpg',
        'HALO-Naiyang/2.png',
        'HALO-Naiyang/3.jpg',
        'HALO-Naiyang/4.jpg',
        'HALO-Naiyang/5.jpg',
        'HALO-Naiyang/6.jpg',
        'HALO-Naiyang/7.jpg',
        'HALO-Naiyang/8.jpg',
        'HALO-Naiyang/9.jpg',
        'HALO-Naiyang/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'HERITAGE Bang-Tao',
        'price_key' => 'projects.price_heritage_bang_tao',
        'desc_key' => 'projects.desc_heritage_bang_tao',
        'pdf' => 'assets/projects/pdf/2 Heritage Bang-Tao.pdf',
        'images' => [
        'HERITAGE-BangTao/1.jpg',
        'HERITAGE-BangTao/2.jpg',
        'HERITAGE-BangTao/3.jpg',
        'HERITAGE-BangTao/4.jpg',
        'HERITAGE-BangTao/5.jpg',
        'HERITAGE-BangTao/6.jpg',
        'HERITAGE-BangTao/7.jpg',
        'HERITAGE-BangTao/8.jpg',
        'HERITAGE-BangTao/9.jpg',
        'HERITAGE-BangTao/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'LEGENDARY Bang-Tao',
        'price_key' => 'projects.price_legendary_bang_tao',
        'desc_key' => 'projects.desc_legendary_bang_tao',
        'pdf' => 'assets/projects/pdf/3 Legendary Bang-Tao.pdf',
        'images' => [
        'LEGENDARY-BangTao/1.jpg',
        'LEGENDARY-BangTao/2.jpg',
        'LEGENDARY-BangTao/3.jpg',
        'LEGENDARY-BangTao/4.jpg',
        'LEGENDARY-BangTao/5.jpg',
        'LEGENDARY-BangTao/6.jpg',
        'LEGENDARY-BangTao/7.jpg',
        'LEGENDARY-BangTao/8.jpg',
        'LEGENDARY-BangTao/9.jpg',
        'LEGENDARY-BangTao/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'SERENITY Naiyang',
        'price_key' => 'projects.price_serenity_naiyang',
        'desc_key' => 'projects.desc_serenity_naiyang',
        'pdf' => 'assets/projects/pdf/4 Serenity Naiyang.pdf',
        'images' => [
        'SERENITY-Naiyang/1.jpg',
        'SERENITY-Naiyang/2.jpg',
        'SERENITY-Naiyang/3.jpg',
        'SERENITY-Naiyang/4.jpg',
        'SERENITY-Naiyang/5.jpg',
        'SERENITY-Naiyang/6.jpg',
        'SERENITY-Naiyang/7.jpg',
        'SERENITY-Naiyang/8.jpg',
        'SERENITY-Naiyang/9.jpg',
        'SERENITY-Naiyang/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'MODEVA Bang-Tao',
        'price_key' => 'projects.price_modeva_bang_tao',
        'desc_key' => 'projects.desc_modeva_bang_tao',
        'pdf' => 'assets/projects/pdf/5 THE MODEVA Bang-Tao.pdf',
        'images' => [
        'MODEVA-BangTao/1.jpg',
        'MODEVA-BangTao/2.jpg',
        'MODEVA-BangTao/3.jpg',
        'MODEVA-BangTao/4.jpg',
        'MODEVA-BangTao/5.jpg',
        'MODEVA-BangTao/6.jpg',
        'MODEVA-BangTao/7.jpg',
        'MODEVA-BangTao/8.jpg',
        'MODEVA-BangTao/9.jpg',
        'MODEVA-BangTao/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'CIELO Rawai',
        'price_key' => 'projects.price_cielo_rawai',
        'desc_key' => 'projects.desc_cielo_rawai',
        'pdf' => 'assets/projects/pdf/6 Cielo Rawai.pdf',
        'images' => [
        'CIELO-Rawai/1.jpg',
        'CIELO-Rawai/2.jpg',
        'CIELO-Rawai/3.jpg',
        'CIELO-Rawai/4.jpg',
        'CIELO-Rawai/5.jpg',
        'CIELO-Rawai/6.jpg',
        'CIELO-Rawai/7.jpg',
        'CIELO-Rawai/8.jpg',
        'CIELO-Rawai/9.jpg',
        'CIELO-Rawai/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'ARTRIO BangTao',
        'price_key' => 'projects.price_artrio_bang_tao',
        'desc_key' => 'projects.desc_artrio_bang_tao',
        'pdf' => 'assets/projects/pdf/7 Artrio Bang-Tao.pdf',
        'images' => [
        'ARTRIO-BangTao/1.png',
        'ARTRIO-BangTao/2.jpg',
        'ARTRIO-BangTao/3.jpg',
        'ARTRIO-BangTao/4.jpg',
        'ARTRIO-BangTao/5.jpg',
        'ARTRIO-BangTao/6.jpg',
        'ARTRIO-BangTao/7.jpg',
        'ARTRIO-BangTao/8.jpg',
        'ARTRIO-BangTao/9.png',
        'ARTRIO-BangTao/10.png',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'KATABELLO Kata',
        'price_key' => 'projects.price_katabello_kata',
        'desc_key' => 'projects.desc_katabello_kata',
        'pdf' => 'assets/projects/pdf/8 The Katabello Kata.pdf',
        'images' => [
        'KATABELLO-Kata/1.jpg',
        'KATABELLO-Kata/2.jpg',
        'KATABELLO-Kata/3.jpg',
        'KATABELLO-Kata/4.jpg',
        'KATABELLO-Kata/5.jpg',
        'KATABELLO-Kata/6.jpg',
        'KATABELLO-Kata/7.jpg',
        'KATABELLO-Kata/8.jpg',
        'KATABELLO-Kata/9.jpg',
        'KATABELLO-Kata/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'ADORA Rawai',
        'price_key' => 'projects.price_adora_rawai',
        'desc_key' => 'projects.desc_adora_rawai',
        'pdf' => 'assets/projects/pdf/9 Adora Rawai.pdf',
        'images' => [
        'adora-rawai/1.jpg',
        'adora-rawai/2.jpg',
        'adora-rawai/3.jpg',
        'adora-rawai/4.jpg',
        'adora-rawai/5.jpg',
        'adora-rawai/6.jpg',
        'adora-rawai/7.jpg',
        'adora-rawai/8.jpg',
        'adora-rawai/9.jpg',
        'adora-rawai/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed',
        'title' => 'SIERRA Bang-Tao',
        'price_key' => 'projects.price_sierra_bang_tao',
        'desc_key' => 'projects.desc_sierra_bang_tao',
        'pdf' => 'assets/projects/pdf/10 Sierra Bang-Tao.pdf',
        'images' => [
        'SIERRA-BangTao/1.png',
        'SIERRA-BangTao/2.jpg',
        'SIERRA-BangTao/3.png',
        'SIERRA-BangTao/4.png',
        'SIERRA-BangTao/5.png',
        'SIERRA-BangTao/6.png',
        'SIERRA-BangTao/7.png',
        'SIERRA-BangTao/8.png',
        'SIERRA-BangTao/9.png',
        'SIERRA-BangTao/10.jpeg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_2_4_bed',
        'title' => 'VILLA KIRARA Bang-Tao',
        'price_key' => 'projects.price_villa_kirara_bang_tao',
        'desc_key' => 'projects.desc_villa_kirara_bang_tao',
        'pdf' => 'assets/projects/pdf/11 Villa Kirara Bang-Tao.pdf',
        'images' => [
        'VILLA-KIRARA-Bang-Tao/1.jpeg',
        'VILLA-KIRARA-Bang-Tao/2.jpeg',
        'VILLA-KIRARA-Bang-Tao/3.jpeg',
        'VILLA-KIRARA-Bang-Tao/4.jpeg',
        'VILLA-KIRARA-Bang-Tao/5.jpeg',
        'VILLA-KIRARA-Bang-Tao/6.jpeg',
        'VILLA-KIRARA-Bang-Tao/7.jpeg',
        'VILLA-KIRARA-Bang-Tao/8.jpeg',
        'VILLA-KIRARA-Bang-Tao/9.jpeg',
        'VILLA-KIRARA-Bang-Tao/10.jpg',
        ],
        ],
        [
        'badge_key' => 'projects.badge_1_2_bed', 
        'title' => 'CORALINA Kamala',
        'price_key' => 'projects.price_coralina_kamala',
        'desc_key' => 'projects.desc_coralina_kamala',
        'pdf' => 'assets/projects/pdf/12 Coralina Kamala.pdf',
        'images' => [
        'CORALINA-Kamala/1.jpg',
        'CORALINA-Kamala/2.jpg',
        'CORALINA-Kamala/3.jpg',
        'CORALINA-Kamala/4.jpg',
        'CORALINA-Kamala/5.jpg',
        'CORALINA-Kamala/6.jpg',
        'CORALINA-Kamala/7.jpg',
        'CORALINA-Kamala/8.jpg',
        'CORALINA-Kamala/9.jpg',
        'CORALINA-Kamala/10.jpeg',
        ],
        ],
        ];
        @endphp

        <div class="space-y-16 ">

          @foreach($projects as $p)
          <div class="project-card bg-white shadow-sm border border-black/5 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-5">

              {{-- LEFT: info card --}}
<div class="md:col-span-2 order-2 md:order-1 p-6 sm:p-7 md:p-8 flex flex-col">
  <div class="text-[#2da9e0] font-semibold text-sm">
    {{ __($p['badge_key']) }}
  </div>

  <div class="mt-2 text-[26px] md:text-[28px] leading-tight font-semibold text-[#222]">
    {{ $p['title'] }}
  </div>

  <div class="mt-2 text-[#2da9e0] font-bold">
    {{ __($p['price_key']) }}
  </div>

  @php
    $paragraphs = preg_split("/\n\s*\n/", trim(__($p['desc_key'])));
  @endphp

  <div class="mt-4 text-[#6b7280] text-[15px] leading-[1.35] space-y-6">
    @foreach($paragraphs as $paragraph)
      <p>{{ trim($paragraph) }}</p>
    @endforeach
  </div>

  <button
    class="btn-lux btn-sweep w-full sm:w-auto mt-8 inline-flex items-center justify-center
        px-5 py-2.5 bg-[#2da9e0] text-white font-semibold
        hover:brightness-110 transition
        relative overflow-hidden"
    x-data
    @click="$dispatch('open-lead', { project: @js($p['title']), pdf: @js($p['pdf']) })">
    {{ __('button_more_details') }}
  </button>
</div>

              {{-- RIGHT: image slider --}}
              <div
                class="md:col-span-3 order-1 md:order-2 relative"
                x-data="{
    images: {{ json_encode($p['images']) }},
    index: 0,
    imageLoaded: false,

    // swipe state
    startX: 0,
    startY: 0,
    isDown: false,
    minSwipe: 35, // ปรับได้ (ยิ่งน้อยยิ่งไว)

    show(nextIndex){
      if (nextIndex === this.index) return;
      this.imageLoaded = false;
      this.index = nextIndex;
    },
    next(){ this.show((this.index + 1) % this.images.length) },
    prev(){ this.show((this.index - 1 + this.images.length) % this.images.length) },

    onTouchStart(e){
      this.startX = e.touches[0].clientX;
      this.startY = e.touches[0].clientY;
    },
    onTouchEnd(e){
      const endX = e.changedTouches[0].clientX;
      const endY = e.changedTouches[0].clientY;

      const dx = endX - this.startX;
      const dy = endY - this.startY;

       // ถ้าลากแนวตั้งเยอะ ให้ปล่อย scroll หน้าเว็บได้
      if (Math.abs(dy) > Math.abs(dx)) return;

      if (dx <= -this.minSwipe) this.next(); // ปัดซ้าย = รูปถัดไป
      if (dx >=  this.minSwipe) this.prev(); // ปัดขวา = รูปก่อนหน้า
    },

    // optional: mouse drag (desktop)
    onMouseDown(e){ this.isDown = true; this.startX = e.clientX; },
    onMouseUp(e){
      if(!this.isDown) return;
      this.isDown = false;
      const dx = e.clientX - this.startX;
      if (dx <= -this.minSwipe) this.next();
      if (dx >=  this.minSwipe) this.prev();
    }
  }">
                <div
                  class="relative h-[300px] sm:h-[360px] md:h-[360px] lg:h-[450px] overflow-hidden select-none touch-pan-y"
                  @touchstart.passive="onTouchStart($event)"
                  @touchend="onTouchEnd($event)"
                  @mousedown="onMouseDown($event)"
                  @mouseup="onMouseUp($event)"
                  @mouseleave="isDown=false">
                  <picture class="absolute inset-0 h-full w-full">
                    <source
                      :srcset="'{{ asset('assets/projects-optimized') }}/' + images[index].replace(/\.(jpe?g|png|webp)$/i, '.webp')"
                      type="image/webp">
                    <img
                      :src="'{{ asset('assets/projects') }}/' + images[index]"
                      @load="imageLoaded = true"
                      :class="imageLoaded ? 'opacity-100' : 'opacity-0'"
                      class="absolute inset-0 h-full w-full object-cover transition-opacity duration-300"
                      alt=""
                      loading="lazy"
                      decoding="async"
                      draggable="false">
                  </picture>

                  <!-- overlay -->
                  <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-black/0 to-black/0 pointer-events-none"></div>

                  <!-- LEFT arrow -->
                  <button
                    @click="prev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2
            h-11 w-11 rounded-full
            bg-white/20 backdrop-blur-md
            border border-white/30
            text-white
            flex items-center justify-center
            shadow-lg hover:bg-white/30 transition"
                    aria-label="Prev">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>

                  <!-- RIGHT arrow -->
                  <button
                    @click="next()"
                    class="absolute right-4 top-1/2 -translate-y-1/2
            h-11 w-11 rounded-full
            bg-white/20 backdrop-blur-md
            border border-white/30
            text-white
            flex items-center justify-center
            shadow-lg hover:bg-white/30 transition"
                    aria-label="Next">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>

                  <!-- dots -->
                  <div class="absolute left-1/2 -translate-x-1/2 bottom-4 flex items-center gap-2">
                    <template x-for="(img, i) in images" :key="i">
                      <button
                        @click="show(i)"
                        class="h-2.5 w-2.5 rounded-full transition border border-white/40"
                        :class="index === i ? 'bg-[#2da9e0] scale-110' : 'bg-white/30 hover:bg-white/50'"
                        aria-label="Go to slide"></button>
                    </template>
                  </div>
                </div>
              </div>

            </div>
            @endforeach

          </div>
        </div>
    </section>
