    {{-- PROPERTY GALLERY --}}
    <section class="bg-[#f3f3f3]">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 pb-10">
        <div class="flex items-end justify-between gap-6 mb-8">
          <div>
            <div class="text-[12px] uppercase tracking-[0.28em] text-[#8a8f98] mb-3">
              {{ $locale === 'ru' ? 'Подборка' : 'Collection' }}
            </div>
            <h2 class="text-[34px] md:text-[40px] font-bold tracking-widest uppercase text-[#2f343a]">
              {{ $locale === 'ru' ? 'Фотогалерея' : 'OWNERSHIP TRANSFER' }}
            </h2>
          </div>

          <p class="hidden md:block max-w-xl text-[15px] leading-7 text-[#6b7280]">
            {{ $locale === 'ru'
                ? 'Фотографии успешной передачи права собственности нашим клиентам.'
                : 'A collection of successful property ownership transfers.' }}
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
          <div class="overflow-hidden rounded-[6px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('img/optimized/IMG_6140.webp') }}" alt="Sanbada property image 1" class="w-full h-[260px] object-cover hover:scale-[1.03] transition duration-500" loading="lazy" decoding="async" />
          </div>
          <div class="overflow-hidden rounded-[6px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('img/optimized/IMG_7704.webp') }}" alt="Sanbada property image 2" class="w-full h-[260px] object-cover hover:scale-[1.03] transition duration-500" loading="lazy" decoding="async" />
          </div>
          <div class="overflow-hidden rounded-[6px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('img/optimized/IMG_7794.webp') }}" alt="Sanbada property image 3" class="w-full h-[260px] object-cover hover:scale-[1.03] transition duration-500" loading="lazy" decoding="async" />
          </div>
          <div class="overflow-hidden rounded-[6px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('img/optimized/IMG_7859.webp') }}" alt="Sanbada property image 4" class="w-full h-[260px] object-cover hover:scale-[1.03] transition duration-500" loading="lazy" decoding="async" />
          </div>
          <div class="overflow-hidden rounded-[6px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('img/optimized/IMG_8211.webp') }}" alt="Sanbada property image 5" class="w-full h-[260px] object-cover hover:scale-[1.03] transition duration-500" loading="lazy" decoding="async" />
          </div>
          <div class="overflow-hidden rounded-[6px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('img/optimized/S__7086088_0.webp') }}" alt="Sanbada property image 6" class="w-full h-[260px] object-cover hover:scale-[1.03] transition duration-500" loading="lazy" decoding="async" />
          </div>
        </div>
      </div>
    </section>
