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
      <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center gap-2">
        <img src="{{ asset('assets/brand/logo-gold.png') }}" alt="Sanbada Real Estate" class="h-7 w-auto">
        <div class="leading-tight">
          <div class="text-white font-semibold tracking-widest uppercase text-sm">SANBADA</div>
          <div class="text-white/70 text-[11px] tracking-wide">Real estate</div>
        </div>
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

      </div>
    </div>

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
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/brand/logo-gold.png') }}" class="h-7 w-auto" alt="Sanbada">
              <div class="leading-tight">
                <div class="text-white font-semibold tracking-widest uppercase text-sm">SANBADA</div>
                <div class="text-white/60 text-[11px] tracking-wide">Real estate</div>
              </div>
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
                  class="bg-[url('/assets/hero/hero-01.jpg')]
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
                  class="bg-[url('/assets/hero/hero-01.jpg')]
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
                src="{{ asset('assets/hero/hero-01.jpg') }}"
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

    <section class="relative bg-black"
      x-data="promoHero()"
      x-init="init($el)">
      <div class="relative h-[520px] sm:h-[620px] lg:h-[720px] overflow-hidden">

        <img
          src="{{ asset('assets/hero/beach-2084350_1920.jpg') }}"
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
              src="{{ asset('assets/about/team.jpg') }}"
              alt="Sanbada Team"
              class="w-full h-auto object-cover" />
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
              src="{{ asset('assets/investment/1.jpg') }}"
              alt="Investment Phuket"
              class="w-full h-full object-cover" />
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
                  src="{{ asset('assets/investment/2.jpg') }}"
                  alt="Advantage 1"
                  class="w-full h-full object-cover" />
              </div>
            </div>
          </div>

          {{-- Row 2: image left / text right --}}
          <div class="bg-white border border-black/5">
            <div class="grid lg:grid-cols-2 items-stretch">
              <div class="overflow-hidden">
                <img
                  src="{{ asset('assets/investment/3.jpg') }}"
                  alt="Advantage 2"
                  class="w-full h-full object-cover" />
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
                  src="{{ asset('assets/investment/4.jpg') }}"
                  alt="Advantage 3"
                  class="w-full h-full object-cover" />
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>


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
          <div class="bg-white shadow-sm border border-black/5 overflow-hidden">
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

    // swipe state
    startX: 0,
    startY: 0,
    isDown: false,
    minSwipe: 35, // ปรับได้ (ยิ่งน้อยยิ่งไว)

    next(){ this.index = (this.index + 1) % this.images.length },
    prev(){ this.index = (this.index - 1 + this.images.length) % this.images.length },

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
                  <template x-for="(img, i) in images" :key="i">
                    <picture
                      x-show="index === i"
                      x-transition.opacity.duration.250ms
                      class="absolute inset-0 w-full h-full">
                      <source
                        :srcset="`{{ asset('assets/projects') }}/${img.replace(/\.(jpe?g|png)$/i, '.webp')}`"
                        type="image/webp">
                      <img
                        :src="`{{ asset('assets/projects') }}/${img}`"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt=""
                        loading="lazy"
                        draggable="false">
                    </picture>
                  </template>

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
                        @click="index = i"
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