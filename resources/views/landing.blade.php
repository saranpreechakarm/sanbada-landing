<!doctype html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sanbada Real Estate</title>

  <link rel="icon" href="{{ asset('logo ขาวดำ.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

  <style>[x-cloak] { display: none !important; }</style>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <!-- Marquiz script start -->
  <script>
    (function(w, d, s, o) {
      var j = d.createElement(s);
      j.async = true;
      j.src = '//script.marquiz.ru/v2.js';
      j.onload = function() {
        if (document.readyState !== 'loading') Marquiz.init(o);
        else document.addEventListener("DOMContentLoaded", function() {
          Marquiz.init(o);
        });
      };
      d.head.insertBefore(j, d.head.firstElementChild);
    })(window, document, 'script', {
      host: '//quiz.marquiz.ru',
      region: 'ru',
      id: '694f90aa56ae670019803ad9',
      autoOpen: false,
      autoOpenFreq: 'once',
      openOnExit: false,
      disableOnMobile: false
    });
  </script>
  <!-- Marquiz script end -->
</head>

<body class="bg-[#efefef] text-black">

  {{-- NAVBAR --}}
  @php
  $locale = app()->getLocale(); // ru | en
  $segments = request()->segments();

  // remove locale prefix to keep current path when switching
  if (in_array($segments[0] ?? '', ['ru','en'])) array_shift($segments);
  $path = implode('/', $segments);

  $ruUrl = url('/ru' . ($path ? '/' . $path : ''));
  $enUrl = url('/en' . ($path ? '/' . $path : ''));
  @endphp

  <header class="sticky top-0 z-40 bg-[#2f343a] border-b border-black/30"
    x-data="{ mobileOpen:false }"
    @toggle-mobile-menu.window="mobileOpen = !mobileOpen"
    @keydown.escape.window="mobileOpen=false"
    @scroll.window="if (mobileOpen) mobileOpen = false">
    <div class="w-full max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">

      {{-- Brand --}}
      <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center">
        <img
          src="{{ asset('assets/brand/logo-x-navbar.webp') }}"
          alt="Sanbada x Submanee Property"
          width="603"
          height="87"
          class="h-10 w-auto">
      </a>

      {{-- Desktop menu --}}
      <nav class="hidden md:flex items-center gap-10 text-[12px] tracking-[.20em] uppercase text-white/80">
        <a href="#about" class="scroll-mt-20 hover:text-white transition">{{ __('about us') }}</a>
        <a href="#invest" class="scroll-mt-20 hover:text-white transition">{{ __('investments') }}</a>
        <a href="#projects" class="scroll-mt-20 hover:text-white transition">{{ __('projects') }}</a>
        <a href="#contacts" class="scroll-mt-20 hover:text-white transition">{{ __('contacts') }}</a>
      </nav>

      {{-- Right actions: language switch + mobile button --}}
      <div class="flex items-center gap-3">

        {{-- Language dropdown (desktop) --}}
        <div class="hidden md:block relative"
          x-data="{ open:false }"
          @keydown.escape.window="open=false">

          <button type="button"
            @click="open = !open"
            class="inline-flex items-center gap-2 h-10 px-3 rounded-full
                 bg-white/10 border border-white/15 text-white/90
                 hover:bg-white/15 transition"
            aria-label="Language"
            :aria-expanded="open.toString()">
            <span class="text-lg leading-none">
              {{ $locale === 'ru' ? '🇷🇺' : '🇬🇧' }}
            </span>
            <span class="text-[13px] font-medium">
              {{ $locale === 'ru' ? 'Русский' : 'English' }}
            </span>
            <svg class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
            </svg>
          </button>

          <div x-cloak
            x-show="open"
            x-transition.opacity
            @click.away="open=false"
            class="absolute right-0 mt-2 w-52 overflow-hidden rounded-xl
              bg-white shadow-xl ring-1 ring-black/5">

            <a href="{{ $ruUrl }}"
              class="flex items-center gap-3 px-4 py-3 text-[14px]
              hover:bg-slate-50 {{ $locale==='ru' ? 'bg-slate-50' : '' }}">
              <span class="text-lg">🇷🇺</span>
              <div class="leading-tight">
                <div class="text-slate-800 font-medium">Русский</div>
              </div>
            </a>

            <a href="{{ $enUrl }}"
              class="flex items-center gap-3 px-4 py-3 text-[14px]
              hover:bg-slate-50 {{ $locale==='en' ? 'bg-slate-50' : '' }}">
              <span class="text-lg">🇬🇧</span>
              <div class="leading-tight">
                <div class="text-slate-800 font-medium">English</div>
              </div>
            </a>
          </div>
        </div>

{{-- Mobile button --}}
        <button
          class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-lg border border-white/15 text-white/80 hover:text-white hover:border-white/25"
          @click="$dispatch('toggle-mobile-menu')"
          aria-label="Menu">
          ☰
        </button>

    {{-- MOBILE DRAWER --}}
    <div class="md:hidden">
      {{-- Backdrop --}}
      <div
        x-show="mobileOpen"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-50 bg-black/60"
        @click="mobileOpen=false"></div>

      {{-- Panel --}}
      <div
        x-show="mobileOpen"
        x-transition:enter="transition transform ease-out duration-250"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        x-cloak
        class="fixed top-0 right-0 z-50 h-full w-[86%] max-w-sm
             bg-[#2b3036] border-l border-white/10 shadow-2xl">
        {{-- Header in drawer --}}
        <div class="h-16 px-6 flex items-center justify-between border-b border-white/10">
          <div class="flex items-center gap-3">

            {{-- Brand --}}
            <div class="flex items-center">
              <img
                src="{{ asset('assets/brand/logo-x-navbar.webp') }}"
                class="h-6 w-auto"
                width="603"
                height="87"
                alt="Sanbada x Submanee Property">
            </div>

            {{-- Language dropdown (mobile in drawer header) --}}
            <div class="relative"
              x-data="{ open:false }"
              @keydown.escape.window="open=false">

              <button type="button"
                @click="open = !open"
                class="inline-flex items-center gap-2 h-9 px-3 rounded-full
                     bg-white/10 border border-white/15 text-white/90
                     hover:bg-white/15 transition"
                aria-label="Language"
                :aria-expanded="open.toString()">
                <span class="text-base leading-none">
                  {{ $locale === 'ru' ? '🇷🇺' : '🇬🇧' }}
                </span>
                <span class="text-[12px] font-medium">
                  {{ $locale === 'ru' ? 'RU' : 'EN' }}
                </span>
                <svg class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                </svg>
              </button>

              <div x-cloak
                x-show="open"
                x-transition.opacity
                @click.away="open=false"
                class="absolute left-0 mt-2 w-52 overflow-hidden rounded-xl
                  bg-white shadow-xl ring-1 ring-black/5 z-50">

                <a href="{{ $ruUrl }}"
                  class="flex items-center gap-3 px-4 py-3 text-[14px]
                  hover:bg-slate-50 {{ $locale==='ru' ? 'bg-slate-50' : '' }}">
                  <span class="text-lg">🇷🇺</span>
                  <div class="leading-tight">
                    <div class="text-slate-800 font-medium">Русский</div>
                  </div>
                </a>

                <a href="{{ $enUrl }}"
                  class="flex items-center gap-3 px-4 py-3 text-[14px]
                  hover:bg-slate-50 {{ $locale==='en' ? 'bg-slate-50' : '' }}">
                  <span class="text-lg">🇬🇧</span>
                  <div class="leading-tight">
                    <div class="text-slate-800 font-medium">English</div>

                  </div>
                </a>

              </div>
            </div>

          </div>

          {{-- Close --}}
          <button
            class="h-10 w-10 rounded-xl border border-white/15 text-white/80 hover:text-white hover:border-white/25 transition"
            @click="mobileOpen=false"
            aria-label="Close">
            ✕
          </button>
        </div>



        {{-- Links --}}
        <nav class="px-6 py-6 text-[12px] uppercase tracking-[.18em]">

          <a href="#about"
            @click.prevent="
            mobileOpen=false;
            document.querySelector('#about')?.scrollIntoView({behavior:'smooth', block:'start'});
          "
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ __('about us') }}
          </a>

          <a href="#invest"
            @click.prevent="
            mobileOpen=false;
            document.querySelector('#invest')?.scrollIntoView({behavior:'smooth', block:'start'});
          "
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ __('investments') }}
          </a>

          <a href="#projects"
            @click.prevent="
            mobileOpen=false;
            document.querySelector('#projects')?.scrollIntoView({behavior:'smooth', block:'start'});
          "
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ __('projects') }}
          </a>

          <a href="#contacts"
            @click.prevent="
            mobileOpen=false;
            document.querySelector('#contacts')?.scrollIntoView({behavior:'smooth', block:'start'});
          "
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ __('contacts') }}
          </a>



          {{-- CTA --}}
          <button
            class="w-full mt-8 h-12 rounded-xl bg-[#2da9e0] text-white font-semibold tracking-wide hover:brightness-110 transition"
            x-data
            @click="$dispatch('open-lead'); mobileOpen=false">
            {{ __('Получить подборку') }}
          </button>

          <div class="mt-4 text-xs text-white/45 leading-relaxed">
            {{ __('Мы свяжемся с вами в WhatsApp и отправим актуальные цены и планировки.') }}
          </div>
        </nav>
      </div>
    </div>
  </header>

  {{-- MAIN --}}
  <main class="overflow-x-hidden">
    @include('landing.sections.hero')
    @include('landing.sections.ownership-transfer')
    @include('landing.sections.promo')
    @include('landing.sections.about')
    @include('landing.sections.submanee-property')
    @include('landing.sections.services')
    @include('landing.sections.investment')
    @include('landing.sections.advantages')
    @include('landing.sections.projects')
    @include('landing.sections.contact')


  </main>

  {{-- MODAL --}}
  <div
    x-data="{ open:false, project:null, pdf:null }"
    @open-lead.window="
    open = true;
    project = $event.detail?.project ?? null;
    pdf = $event.detail?.pdf ?? null;
  "
    @keydown.escape.window="open = false"
    x-cloak>

    {{-- overlay --}}
    <div
      x-show="open"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 bg-black/70 backdrop-blur-[2px]"
      @click="open=false"></div>

    {{-- modal wrapper --}}
    <div
      x-show="open"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
      aria-modal="true"
      role="dialog">
      {{-- modal box --}}
      <div
        x-transition:enter="transition ease-out duration-320"
        x-transition:enter-start="opacity-0 translate-y-6 scale-[0.98]"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-[0.98]"
        class="relative w-full max-w-5xl overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl"
        style="box-shadow: 0 20px 80px rgba(0,0,0,.55);"
        @click.stop>
        {{-- top bar --}}
        <div class="flex items-center justify-between px-5 sm:px-8 py-4 border-b border-black/10 bg-white">
          <div class="text-sm sm:text-base font-semibold text-[#111]">
            Sanbada Real Estate
          </div>

          <button
            class="h-10 w-10 rounded-full bg-black/5 hover:bg-black/10 text-black/60 hover:text-black flex items-center justify-center transition"
            @click="open=false"
            aria-label="Close">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
            </svg>
          </button>
        </div>

        {{-- body (limit height + internal scroll) --}}
        <div class="max-h-[85vh] overflow-y-auto">
          <div class="grid md:grid-cols-2">

            {{-- left content --}}
            <div class="p-6 sm:p-8 md:p-10 bg-[#f6f7f9]">
              <div class="inline-flex items-center gap-2 text-xs font-semibold tracking-wide uppercase text-[#2da9e0]">
                <span class="h-2 w-2 rounded-full bg-[#2da9e0]"></span>
                {{ __('modal_1') }}
              </div>

              <h2 class="mt-3 text-2xl sm:text-3xl font-extrabold leading-tight text-[#111]">
                {{ __('modal_2') }}
              </h2>

              <p class="mt-5 font-semibold text-[#111]">
                {{ __('modal_3') }}
              </p>

              <div class="mt-6 rounded-xl border border-black/10 bg-white p-4 text-sm text-black/70">
                {{ __('modal_4') }}
                <span class="font-semibold" x-text="project ? project : ''"></span>
              </div>

              <ul class="mt-3 space-y-2 text-[#334155]">
                <li class="flex gap-2">
                  <span class="mt-[6px] h-1.5 w-1.5 rounded-full bg-[#2da9e0]"></span>
                  <span>{{ __('modal_5') }}</span>
                </li>
                <li class="flex gap-2">
                  <span class="mt-[6px] h-1.5 w-1.5 rounded-full bg-[#2da9e0]"></span>
                  <span>{{ __('modal_6') }}</span>
                </li>
                <li class="flex gap-2">
                  <span class="mt-[6px] h-1.5 w-1.5 rounded-full bg-[#2da9e0]"></span>
                  <span>{{ __('modal_7') }}</span>
                </li>
              </ul>

              <div class="mt-6 rounded-xl border border-black/10 bg-white p-4 text-sm text-black/60">
                {{ __('modal_8') }}
              </div>
            </div>

            {{-- right form --}}
            <div class="p-6 sm:p-8 md:p-10">
              <form method="POST" action="{{ route('lead.store', app()->getLocale()) }}" class="space-y-4">
                @csrf
                <input type="hidden" name="source" value="website">
                <input type="hidden" name="project" :value="project">
                <input type="hidden" name="pdf" :value="pdf">

                {{-- WhatsApp --}}
                <div>
                  <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">
                    {{ __('modal_9') }}
                  </label>

                  <div class="mt-2 grid grid-cols-[110px_1fr] gap-2">
                    <select
                      name="whatsapp_country"
                      class="h-12 rounded-xl border border-black/15 bg-white px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15">
                      <option value="+66">+66</option>
                      <option value="+7">+7</option>
                      <option value="+48">+48</option>
                      <option value="+1">+1</option>
                    </select>

                    <input
                      name="whatsapp_phone"
                      required
                      inputmode="tel"
                      placeholder="{{ __('modal_16') }}"
                      class="h-12 rounded-xl border border-black/15 px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15">
                  </div>

                  @error('whatsapp_phone')
                  <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Email --}}
                <div>
                  <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">
                    {{ __('modal_10') }}
                  </label>

                  <input
                    name="email"
                    type="email"
                    placeholder="mail@example.com"
                    class="mt-2 h-12 w-full rounded-xl border border-black/15 px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15">

                  @error('email')
                  <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Name --}}
                <div>
                  <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">
                    {{ __('modal_11') }}
                  </label>

                  <input
                    name="name"
                    placeholder="{{ __('modal_17') }}"
                    class="mt-2 h-12 w-full rounded-xl border border-black/15 px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15">
                </div>

                {{-- Submit --}}
                <button
                  class="mt-2 h-12 w-full rounded-full bg-[#2da9e0] text-white font-semibold hover:brightness-110 transition">
                  {{ __('modal_12') }}
                </button>

                {{-- consent --}}
                <label class="flex gap-3 items-start text-sm text-black/60">
                  <input
                    name="consent"
                    type="checkbox"
                    value="1"
                    required
                    class="mt-1 h-4 w-4 rounded border-black/20 text-[#2da9e0] focus:ring-[#2da9e0]/30">
                  <span>
                    {{ __('modal_13') }}
                    <a class="text-[#2da9e0] underline hover:opacity-80" href="{{ route('privacy', app()->getLocale()) }}">
                      {{ __('modal_14') }}
                    </a>
                  </span>
                </label>

                @error('consent')
                <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
              </form>

              <div class="mt-6 text-xs text-black/40">
                {{ __('modal_15') }}
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <!-- Marquiz Widget Code (put before </body>) -->
    <script>
      (function(t, p) {
        window.Marquiz ?
          Marquiz.add([t, p]) :
          document.addEventListener('marquizLoaded', function() {
            Marquiz.add([t, p])
          })
      })('Widget', {
        id: '694f90aa56ae670019803ad9',
        position: 'right',
        delay: 3,
        disableOnMobile: false,
        disableIfClosed: false,
        gradientEnabled: true,
        gradientColor: '#303537',
        gradientIntensity: 40,
        titleColor: '#ffffff',
        hiddenArrowOnMobile: false,
        autoOpen: 3
      });
    </script>

</body>

</html>

