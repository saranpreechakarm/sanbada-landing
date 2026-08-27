    {{-- HERO (match reference image) --}}
    <section class="relative">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10 lg:py-10">
        <div class="grid min-[1291px]:grid-cols-2 grid-cols-1 gap-14 items-center">


          {{-- LEFT CONTENT --}}
          <div>
            <div class="text-sm tracking-[.3em] uppercase text-[#7a8794] mb-6">
              Welcome to Thailand
            </div>

            <h1 class="leading-[0.95]
                   text-[48px] sm:text-[64px] lg:text-[113px]
                   tracking-tight">
              {{-- SANBADA (normal color) --}}
              <span class="block font-['Bicubik'] text-black/75">
                SANBADA
              </span>

              {{-- REAL EST (>=1291px) --}}
              <span class="block font-['Bicubik'] min-[1291px]:block max-[1290px]:hidden">
                <span
                  class="bg-[url('/assets/optimized/hero/hero-01.webp')]
                    bg-no-repeat bg-cover
                    bg-clip-text
                    [background-position:75%_55%]
                    [background-size:900px_auto]
                    text-black/75">
                  REAL&nbsp;EST
                </span>
              </span>

              {{-- REAL ESTATE (<1291px) --}}
              <span class="block font-['Bicubik'] min-[1291px]:hidden max-[1290px]:block">
                <span
                  class="bg-[url('/assets/optimized/hero/hero-01.webp')]
                    bg-no-repeat bg-cover
                    bg-clip-text
                    [background-position:75%_55%]
                    [background-size:900px_auto]
                    text-black/75">
                  REAL&nbsp;ESTATE
                </span>
              </span>
            </h1>

            <div class="mt-8 h-[8px] w-70 bg-[#2da9e0]"></div>

            <p class="mt-8 max-w-xl text-[19px] leading-relaxed text-[#5f6b75]">
              {{ __('hero_intro') }}
            </p>
          </div>

          {{-- RIGHT IMAGE --}}
          <div class="relative overflow-visible">
            <div class="relative overflow-hidden">
              <img
                src="{{ asset('assets/optimized/hero/hero-01.webp') }}"
                alt="Sanbada Building"
                class="
              w-full object-cover

              /* <1291px: ทำให้ดูสวยทุกจอ */
              max-[1290px]:aspect-[16/11]
              max-[1290px]:h-auto
              max-[1290px]:object-[70%_55%]
              max-[1290px]:rounded-2xl

              /* >=1291px: ใช้แบบเดิม (ที่บังบอกโอเคแล้ว) */
              min-[1291px]:h-[560px]
              min-[1291px]:rounded-none
            " />

              {{-- ATE overlay on image --}}
              <span
                class="pointer-events-none absolute z-10
                  font-['Bicubik'] tracking-tight
                  text-[#eaeaea]
                  text-[48px] sm:text-[64px] lg:text-[112px]
                  left-[-px] top-[176px]
                  min-[1291px]:block max-[1290px]:hidden">
                ATE
              </span>
            </div>
          </div>

        </div>
      </div>
    </section>
