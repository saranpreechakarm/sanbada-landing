    {{-- EXCLUSIVE ADVANTAGES (match screenshot 2) --}}
    <section class="bg-[#efefef]">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

        <h2 class="text-[#2f343a] font-bold uppercase tracking-wider text-[28px] leading-tight">
          {{ __('EXCLUSIVE_1') }}<br>
          {{ __('EXCLUSIVE_2') }}
        </h2>

        <div class="mt-10 space-y-8">

          {{-- Row 1: text left / image right --}}
          <div class="bg-white border border-black/5">
            <div class="grid lg:grid-cols-2 items-stretch">
              <div class="p-10 flex items-center">
                <div>
                  <div class="text-[#6b7280] font-semibold text-[25px]">
                    {{ __('EXCLUSIVE_3') }}<br>{{ __('EXCLUSIVE_4') }}
                  </div>
                  <div class="mt-2 text-[#7a8794] text-[20px]">
                    {{ __('EXCLUSIVE_5') }}
                  </div>
                </div>
              </div>

              <div class="overflow-hidden">
                <img
                  src="{{ asset('assets/optimized/investment/2.webp') }}"
                  alt="Advantage 1"
                  class="w-full h-full object-cover" loading="lazy" decoding="async" />
              </div>
            </div>
          </div>

          {{-- Row 2: image left / text right --}}
          <div class="bg-white border border-black/5">
            <div class="grid lg:grid-cols-2 items-stretch">
              <div class="overflow-hidden">
                <img
                  src="{{ asset('assets/optimized/investment/3.webp') }}"
                  alt="Advantage 2"
                  class="w-full h-full object-cover" loading="lazy" decoding="async" />
              </div>

              <div class="p-10 flex items-center">
                <div>
                  <div class="text-[#6b7280] font-semibold text-[25px]">
                    {{ __('EXCLUSIVE_6') }}<br>{{ __('EXCLUSIVE_7') }}
                  </div>
                  <div class="mt-2 text-[#7a8794] text-[20px] leading-relaxed max-w-xl">
                    {{ __('EXCLUSIVE_8') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Row 3: text left / image right --}}
          <div class="bg-white border border-black/5">
            <div class="grid lg:grid-cols-2 items-stretch">
              <div class="p-10 flex items-center">
                <div>
                  <div class="text-[#6b7280] font-semibold text-[25px]">
                    <span class="text-[#2da9e0] font-bold">40%</span><br>
                    <span class="text-[#7a8794] text-[20px] font-normal">
                      {{ __('EXCLUSIVE_9') }}<br>{{ __('EXCLUSIVE_10') }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="overflow-hidden">
                <img
                  src="{{ asset('assets/optimized/investment/4.webp') }}"
                  alt="Advantage 3"
                  class="w-full h-full object-cover" loading="lazy" decoding="async" />
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
