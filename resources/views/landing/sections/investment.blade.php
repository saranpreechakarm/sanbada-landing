    {{-- INVESTMENT (match screenshot 1) --}}
    <section id="invest2" class="bg-[#efefef] scroll-mt-20">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

        {{-- Title --}}
        <h2 class="text-[#2f343a] font-bold uppercase tracking-wider text-[40px]">
          {{ __('INVESTMENT_1') }}
        </h2>

        <p class="mt-2 text-[#7a8794] max-w-2xl leading-snug text-[20px]">
          {{ __('INVESTMENT_2') }}<br>
          {{ __('INVESTMENT_3') }} <span class="font-semibold text-[#2f343a]">{{ __('INVESTMENT_4') }}</span> {{ __('INVESTMENT_5') }}
        </p>

        <div class="mt-4 h-[4px] w-36 bg-[#2da9e0]"></div>

        {{-- Top row: image + text + stats (LOCK HEIGHT like screenshot) --}}
        <div class="mt-10 grid lg:grid-cols-2 gap-10 items-stretch
                lg:h-[260px] xl:h-[320px]">

          {{-- Left image (must fill height) --}}
          <div class="border border-black/5 bg-white overflow-hidden h-full">
            <img
              src="{{ asset('assets/optimized/investment/1.webp') }}"
              alt="Investment Phuket"
              class="w-full h-full object-cover" loading="lazy" decoding="async" />
          </div>

          {{-- Right column (fill same height, stats pinned bottom) --}}
          <div class="flex flex-col h-full">

            {{-- TEXT --}}
            <p class="text-[#7a8794] leading-relaxed max-w-xl text-[20px]">
{{ __('INVESTMENT_6') }}
            </p>

            {{-- STATS (pinned to bottom on desktop) --}}
            <div class="mt-6 lg:mt-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

              <div class="bg-white border border-black/5 p-4 sm:p-5 text-center min-w-0">
                <div class="font-display text-[#2da9e0] font-bold text-[22px] leading-none">8%</div>
                <div class="mt-2 text-[#7a8794] text-[14px] leading-snug break-words">
                  {{ __('INVESTMENT_7') }}
                </div>
              </div>

              <div class="bg-white border border-black/5 p-4 sm:p-5 text-center min-w-0">
                <div class="font-display text-[#2da9e0] font-bold text-[22px] leading-none">15%</div>
                <div class="mt-2 text-[#7a8794] text-[14px] leading-snug break-words">
                  {{ __('INVESTMENT_8') }}
                </div>
              </div>

              <div class="bg-white border border-black/5 p-4 sm:p-5 text-center min-w-0">
                <div class="font-display text-[#2da9e0] font-bold text-[20px] leading-none">
                  {{ __('INVESTMENT_9') }}<br>{{ __('INVESTMENT_10') }}
                </div>
                <div class="mt-2 text-[#7a8794] text-[14px] leading-snug break-words">
                  {{ __('INVESTMENT_11') }}
                </div>
              </div>

            </div>
          </div>
        </div>

        {{-- Middle info bar --}}
        <div class="mt-10 bg-white border border-black/5">
          <div class="h-[4px] w-36 bg-[#2da9e0]"></div>

          <div class="grid lg:grid-cols-[1fr_360px] gap-10 px-6 py-6 items-center">
            <div>
              <div class="text-[20px] font-semibold text-[#2f343a]">
                {{ __('INVESTMENT_12') }}
              </div>
              <p class="mt-1 text-[#7a8794] text-[15px] leading-relaxed max-w-2xl">
                {{ __('INVESTMENT_13') }}
              </p>
            </div>

            <div class="text-right">
              <div class="font-bold text-[40px] tracking-tight">
                <span class="block font-['Bicubik'] text-[#2da9e0]">13–16%</span>
                <span class="block font-['Bicubik'] text-[#2f343a] uppercase">{{ __('INVESTMENT_14') }}</span>
              </div>
            </div>
          </div>
        </div>

        {{-- Bottom info bar --}}
        <div class="mt-6 bg-white border border-black/5">
          <div class="h-[4px] w-36 bg-[#2da9e0]"></div>

          <div class="grid lg:grid-cols-[1fr_360px] gap-10 px-6 py-6 items-center">
            <div>
              <div class="text-[20px] font-semibold text-[#2f343a]">{{ __('INVESTMENT_17') }}</div>
              <p class="mt-1 text-[#7a8794] text-[15px] leading-relaxed max-w-2xl">
                {{ __('INVESTMENT_15') }}
              </p>
            </div>

            <div class="text-right">
              <div class="font-bold tracking-tight">
                <div class="block font-['Bicubik'] text-[#2da9e0] text-[40px] leading-none">80/20</div>
                <div class="block font-['Bicubik'] text-[#2f343a] uppercase text-[25px]">{{ __('INVESTMENT_16') }}</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
