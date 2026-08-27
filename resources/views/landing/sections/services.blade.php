    {{-- SERVICES / BENEFITS (match screenshot) --}}
    <section id="invest" class="bg-[#f3f3f3] scroll-mt-24">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

        {{-- TOP HEAD --}}
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-10">
          <div>
            <h2 class="text-[#2f343a] font-bold uppercase leading-[1.05]
                   text-[34px] sm:text-[42px]">
              {{ __('about_us_text7') }}<br>
              {{ __('about_us_text8') }}
            </h2>
            <div class="mt-10 text-[20px] tracking-[.25em] uppercase text-[#7a8794]">
              {{ __('about_us_text9') }}
            </div>
          </div>

          <div class="md:text-right">
            <div class="block font-['Bicubik'] text-[#2da9e0] font-bold tracking-tight text-center
                    text-[44px] sm:text-[52px] leading-none">
              20+
            </div>
            <div class="mt-2 text-[#7a8794] text-[20px]">
              {{ __('about_us_text10') }}
            </div>
          </div>
        </div>

        {{-- CARDS --}}
        <div class="mt-14 grid md:grid-cols-3 gap-10 items-end">

          {{-- 1 --}}
          <div class="text-center">
            <img src="{{ asset('assets/icon/car.png') }}" alt="Transfer"
              class="mx-auto h-24 sm:h-28 w-auto opacity-90">
            <div class="mt-6 bg-white px-8 py-7 min-h-[200px] flex flex-col justify-start">
              <div class="block font-['Bicubik'] text-[#2da9e0] font-semibold uppercase tracking-[.18em] text-[20px]">
                {{ __('card_1') }}
              </div>
              <p class="mt-4 text-[#7a8794] text-[15px] leading-relaxed">
                {{ __('card_2') }}<br class="hidden sm:block">
                
              </p>
            </div>
          </div>

          {{-- 2 --}}
          <div class="text-center">
            <img src="{{ asset('assets/icon/hand.png') }}" alt="Lawyer"
              class="mx-auto h-24 sm:h-28 w-auto opacity-90">
            <div class="mt-6 bg-white px-8 py-7 min-h-[200px] flex flex-col justify-start">
              <div class="block font-['Bicubik'] text-[#2da9e0] font-semibold uppercase tracking-[.18em] text-[20px]">
                {{ __('card_3') }}
              </div>
              <p class="mt-4 text-[#7a8794] text-[15px] leading-relaxed">
                {{ __('card_4') }}
              </p>
            </div>
          </div>

          {{-- 3 --}}
          <div class="text-center">
            <img src="{{ asset('assets/icon/mondy.png') }}" alt="Profit"
              class="mx-auto h-24 sm:h-28 w-auto opacity-90">
            <div class="mt-6 bg-white px-8 py-7 min-h-[200px] flex flex-col justify-start">
              <div class="block font-['Bicubik'] text-[#2da9e0] font-semibold uppercase tracking-[.18em] text-[20px]">
                {{ __('card_5') }}
              </div>
              <p class="mt-4 text-[#7a8794] text-[15px] leading-relaxed">
                {{ __('card_6') }}
              </p>
            </div>
          </div>

        </div>
      </div>
    </section>
