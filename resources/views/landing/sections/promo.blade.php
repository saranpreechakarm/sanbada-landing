    <section class="relative bg-black"
      x-data="promoHero()"
      x-init="init($el)">
      <div class="relative h-[520px] sm:h-[620px] lg:h-[720px] overflow-hidden">

        <img
          src="{{ asset('assets/optimized/hero/beach-2084350_1920.webp') }}"
          alt="Phuket Sea"
          class="absolute inset-0 w-full h-full object-cover object-center hero-zoom"
          loading="lazy"
          decoding="async" />

        <!-- overlay: ทำให้ดูแพงขึ้น -->
        <div class="absolute inset-0 hero-overlay"></div>

        <div
          class="pointer-events-none absolute left-6 bottom-6
            text-white/90 text-[12px] sm:text-[13px]
            tracking-widest uppercase
            bg-black/40 backdrop-blur-sm
            px-4 py-2 rounded-full border border-white/20">
          {{ __('Kamala_Beach') }}
        </div>
        <!-- Content -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-6">
          <div class="max-w-3xl">

            <h2 class="font-semibold tracking-wide text-red-500
                text-[18px] sm:text-[26px] lg:text-[35px]
                leading-tight uppercase">
              <span
                class="text-shine text-pop"
                :class="animTitle ? 'is-anim' : ''"
                @animationend="onSweepEnd('title', $event)">
                {{ __('hilight1') }}
              </span>
            </h2>

            <h2 class="font-semibold tracking-wide text-white
  text-[18px] sm:text-[26px] lg:text-[35px]
  leading-tight uppercase">

              <span class="block whitespace-nowrap">
                {{ __('hilight2') }}
              </span>

              <span class="block whitespace-nowrap">
                {{ __('hilight3') }}
                <span
                  class="text-shine text-pop text-red-500 font-bold text-glow"
                  :class="animZero ? 'is-anim' : ''"
                  @animationend="onSweepEnd('zero', $event)">
                  0%
                </span>
              </span>
            </h2>


            <div class="mt-8">
              <a
                href="javascript:void(0)"
                x-data
                @click="$dispatch('open-lead')"
                class="btn-lux btn-sweep inline-flex items-center justify-center
                  h-12 px-10 bg-white text-black/80 border border-white/60
                  font-semibold tracking-wide uppercase relative overflow-hidden">
                {{ __('button_go') }}
                <span class="btn-arrow ml-2">→</span>
              </a>
            </div>

          </div>
        </div>
    </section>
