    {{-- footer --}}
    <section id="contacts" class="bg-[#2b2f33] text-white scroll-mt-24">
      <div class="max-w-7xl mx-auto px-6 py-16">

        {{-- GRID: 20% info / 80% map --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-10 items-stretch">

          {{-- LEFT: CONTACT INFO (20%) --}}
          <div class="md:col-span-1">
            <h2 class="text-3xl font-bold text-[#2da9e0] tracking-wide">
              {{ __('contact_us') }}
            </h2>

            {{-- Address --}}
            <div class="mt-8">
              <div class="text-sm font-semibold tracking-widest uppercase text-white/80">
                {{ __('address') }}
              </div>
              <p class="mt-2 text-white/70 leading-relaxed">
                Phuket Office<br>
                27/18 Moo 2, Palai,<br>
                T. Chalong, A. Muang Phuket, Phuket
              </p>
            </div>

            {{-- Phone --}}
            <div class="mt-6">
              <div class="text-sm font-semibold tracking-widest uppercase text-white/80">
                {{ __('phone') }}
              </div>
              <a href="tel:+66653489444" class="mt-2 block text-white/70 hover:text-[#2da9e0]">
                +66 (0) 653 489 444
              </a>
            </div>

            {{-- Email --}}
            <div class="mt-6">
              <div class="text-sm font-semibold tracking-widest uppercase text-white/80">
                Email
              </div>
              <a href="mailto:sanbadarus@gmail.com" class="mt-2 block text-white/70 hover:text-[#2da9e0]">
                sanbadarus@gmail.com
              </a>
            </div>

            {{-- Social --}}
            <div class="mt-8">
              <div class="text-sm font-semibold tracking-widest uppercase text-white/80">
                {{ __('Social') }}
              </div>

              <div class="mt-3 flex gap-4">
                {{-- Telegram --}}
                <a href="https://t.me/sanbadarus" target="_blank"
                  class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9.04 15.43l-.39 5.47c.56 0 .8-.24 1.09-.53l2.62-2.5 5.43 3.97c1 .55 1.72.26 1.98-.92l3.6-16.9c.34-1.57-.57-2.19-1.55-1.83L1.57 9.3c-1.52.6-1.5 1.45-.28 1.82l5.87 1.83L19.8 5.7c.6-.36 1.15-.16.7.24" />
                  </svg>
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/profile.php?id=61579230497512" target="_blank"
                  class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.75-1.6 1.52V12H16l-.5 3h-2.6v7A10 10 0 0022 12z" />
                  </svg>
                </a>

                {{-- Instagram --}}
                <a href="https://www.instagram.com/sanbadarealestate_rus/" target="_blank"
                  class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm5 5a5 5 0 110 10 5 5 0 010-10zm6.5-.75a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0z" />
                  </svg>
                </a>

                {{-- WhatsApp --}}
                <a href="https://wa.me/qr/6XR54RUL5U25N1" target="_blank"
                  class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
                  <svg class="h-5 w-5" viewBox="0 0 32 32" fill="currentColor">
                    <path d="M16.02 3C9.39 3 4 8.38 4 15.01c0 2.64.86 5.18 2.35 7.25L4 29l6.98-2.28a11.94 11.94 0 005.04 1.11h.01c6.62 0 12-5.38 12-12.01C28.03 8.38 22.64 3 16.02 3z" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
          {{-- RIGHT: MAP (80%) --}}
          <div class="md:col-span-4 flex flex-col">
            <div class="flex-1 w-full
                    min-h-[260px]
                    sm:min-h-[360px]
                    md:min-h-[560px]
                    lg:min-h-[456px]
                    overflow-hidden rounded-xl border border-white/10">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4251.00403404192!2d98.35228497582136!3d7.841843606439243!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30502f3d037ab4cd%3A0x7ead3cd5b8f25c69!2sSanbada%20Co.%2CLTD!5e1!3m2!1sth!2sth!4v1769416714833!5m2!1sth!2sth"
                class="w-full h-full border-0"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>

            {{-- bottom nav under map --}}
            <div class="mt-6 flex flex-wrap gap-6 justify-end text-sm tracking-wide text-white/60">
              <a href="{{ route('home', app()->getLocale()) }}" class="hover:text-white">{{ __('back_to_top') }}</a>
              <a href="#about" class="hover:text-white">{{ __('about us') }}</a>
              <a href="#projects" class="hover:text-white">{{ __('projects') }}</a>
              <a href="#invest" class="hover:text-white">{{ __('investments') }}</a>
            </div>
          </div>

        </div>
      </div>
    </section>
