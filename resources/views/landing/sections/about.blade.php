    {{-- ABOUT US --}}
    <section id="about" class="bg-[#f3f3f3] scroll-mt-24">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

        {{-- Section title --}}
        <h2 class="text-[40px] font-bold tracking-widest uppercase text-[#2f343a] mb-10">
          {{ __('about us') }}
        </h2>

        <div class="grid lg:grid-cols-2 gap-12 items-start">

          {{-- LEFT: IMAGE --}}
          <div class="rounded-[4px] overflow-hidden">
            <img
              src="{{ asset('assets/optimized/about/team.webp') }}"
              alt="Sanbada Team"
              class="w-full h-auto object-cover" loading="lazy" decoding="async" />
          </div>

          {{-- RIGHT: TEXT --}}
          <div class="text-[21px] leading-relaxed text-[#6b7280] space-y-5">
            <p>
              {{ __('about_us_text1') }}
            </p>

            <p>
              {{ __('about_us_text2') }} <strong class="text-[#2f343a] font-semibold">{{ __('about_us_text3') }}</strong> {{ __('about_us_text4') }}
              {{ __('about_us_text5') }}
            </p>

            <p>
{{ __('about_us_text6') }}
            </p>
          </div>

        </div>
      </div>
    </section>
