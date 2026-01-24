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
  (function(w, d, s, o){
    var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() {
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
    }
  );
  </script>
  <!-- Marquiz script end -->
</head>

<body class="bg-[#efefef] text-black">

{{-- NAVBAR --}}
<header   class="sticky top-0 z-40 bg-[#2f343a] border-b border-black/30"
  x-data="{ mobileOpen:false }"
  @toggle-mobile-menu.window="mobileOpen = !mobileOpen"
  @keydown.escape.window="mobileOpen=false"
  @scroll.window="if (mobileOpen) mobileOpen = false"
>
  <div class="w-full max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
    {{-- Brand --}}
    <a href="{{ route('home') }}" class="flex items-center gap-2">
      <img src="{{ asset('assets/brand/logo-gold.png') }}" alt="Sanbada Real Estate" class="h-7 w-auto">
      <div class="leading-tight">
        <div class="text-white font-semibold tracking-widest uppercase text-sm">SANBADA</div>
        <div class="text-white/70 text-[11px] tracking-wide">Real estate</div>
      </div>
    </a>

    {{-- Desktop menu --}}
    <nav class="hidden md:flex items-center gap-10 text-[12px] tracking-[.20em] uppercase text-white/80">
      <a href="#about" class="scroll-mt-20 hover:text-white transition">О НАС</a>
      <a href="#invest" class="scroll-mt-20 hover:text-white transition">ИНВЕСТИЦИИ</a>
      <a href="#projects" class="scroll-mt-20 hover:text-white transition">ПРОЕКТЫ</a>
      <a href="#contacts" class="scroll-mt-20 hover:text-white transition">КОНТАКТЫ</a>
    </nav>

    {{-- Mobile button --}}
    <button
      class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-lg border border-white/15 text-white/80 hover:text-white hover:border-white/25"
      @click="$dispatch('toggle-mobile-menu')"
      aria-label="Menu"
    >
      ☰
    </button>
  </div>

{{-- MOBILE DRAWER --}}
<div class="md:hidden">
  {{-- Backdrop --}}
  <div
    x-show="mobileOpen"
    x-transition.opacity
    x-cloak
    class="fixed inset-0 z-50 bg-black/60"
    @click="mobileOpen=false"
  ></div>

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
           bg-[#2b3036] border-l border-white/10 shadow-2xl"
  >
    {{-- Header in drawer --}}
    <div class="h-16 px-6 flex items-center justify-between border-b border-white/10">
      <div class="flex items-center gap-3">
        <img src="{{ asset('assets/brand/logo-gold.png') }}" class="h-7 w-auto" alt="Sanbada">
        <div class="leading-tight">
          <div class="text-white font-semibold tracking-widest uppercase text-sm">SANBADA</div>
          <div class="text-white/60 text-[11px] tracking-wide">Real estate</div>
        </div>
      </div>

      <button
        class="h-10 w-10 rounded-xl border border-white/15 text-white/80 hover:text-white hover:border-white/25 transition"
        @click="mobileOpen=false"
        aria-label="Close"
      >
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
        О НАС
      </a>

      <a href="#invest"
        @click.prevent="
          mobileOpen=false;
          document.querySelector('#invest')?.scrollIntoView({behavior:'smooth', block:'start'});
        "
        class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
        ИНВЕСТИЦИИ
      </a>

      <a href="#projects"
        @click.prevent="
          mobileOpen=false;
          document.querySelector('#projects')?.scrollIntoView({behavior:'smooth', block:'start'});
        "
        class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
        ПРОЕКТЫ
      </a>

      <a href="#contacts"
        @click.prevent="
          mobileOpen=false;
          document.querySelector('#contacts')?.scrollIntoView({behavior:'smooth', block:'start'});
        "
        class="block py-4 text-white/85 hover:text-white transition">
        КОНТАКТЫ
      </a>

      {{-- CTA --}}
      <button
        class="w-full mt-8 h-12 rounded-xl bg-[#2da9e0] text-white font-semibold tracking-wide hover:brightness-110 transition"
        x-data
        @click="$dispatch('open-lead'); mobileOpen=false"
      >
        Получить подборку
      </button>

      <div class="mt-4 text-xs text-white/45 leading-relaxed">
        Мы свяжемся с вами в WhatsApp и отправим актуальные цены и планировки.
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
          Подбираем дома, виллы и квартиры в лучших районах 
          Таиланда — для комфортной жизни, отдыха у моря и 
          долгосрочных инвестиций с профессиональным 
          сопровождением на всех этапах.
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
            "/>

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

{{-- SEA HERO (full image + centered text) --}}
<section class="relative bg-black">
  {{-- Image --}}
  <div class="relative h-[520px] sm:h-[620px] lg:h-[720px] overflow-hidden">
    <img
      src="{{ asset('assets/hero/beach-2084350_1920.jpg') }}"
      alt="Phuket Sea"
      class="absolute inset-0 w-full h-full object-cover object-center"
    />

    {{-- Dark overlay for readability --}}
    <div class="absolute inset-0 bg-black/30"></div>

    {{-- Location label (bottom-left) --}}
    <div
      class="pointer-events-none absolute left-6 bottom-6
            text-white/90
            text-[12px] sm:text-[13px]
            tracking-widest uppercase
            bg-black/40 backdrop-blur-sm
            px-4 py-2 rounded-full border border-white/20"
    >
      Пляж Камала
    </div>

    {{-- Content --}}
    <div class="absolute inset-0 flex items-center justify-center text-center px-6">
      <div class="max-w-3xl">
        <h2 class="font-semibold tracking-wide text-white
                   text-[30px] sm:text-[40px] lg:text-[56px]
                   leading-tight uppercase">
          ПОМОЖЕМ НАЙТИ ТО,<br class="hidden sm:block">
          ЧТО ВЫ ИЩЕТЕ
        </h2>

        <div class="mt-8">
          <a
            href="#projects"
            class="inline-flex items-center justify-center
                   h-12 px-10
                   bg-white text-black/80
                   border border-white/60
                   hover:bg-white/90 transition
                   font-semibold tracking-wide uppercase"
          >
            ПОЕХАЛИ!
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ABOUT US --}}
<section id="about" class="bg-[#f3f3f3] scroll-mt-24">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

    {{-- Section title --}}
    <h2 class="text-[40px] font-bold tracking-widest uppercase text-[#2f343a] mb-10">
      О НАС
    </h2>

    <div class="grid lg:grid-cols-2 gap-12 items-start">

      {{-- LEFT: IMAGE --}}
      <div class="rounded-[4px] overflow-hidden">
        <img
          src="{{ asset('assets/about/team.jpg') }}"
          alt="Sanbada Team"
          class="w-full h-auto object-cover"
        />
      </div>

      {{-- RIGHT: TEXT --}}
      <div class="text-[21px] leading-relaxed text-[#6b7280] space-y-5">
        <p>
          Мы работаем на рынках Пхукета, Паттайи и Чиангмая
          уже много лет, глубоко понимая особенности
          каждого из них.
        </p>

        <p>
          Имея <strong class="text-[#2f343a] font-semibold">более 8 лет опыта</strong> в сфере недвижимости
          и партнёрства с ведущими застройщиками, мы
          предлагаем проверенную и надёжную
          профессиональную поддержку в ключевых регионах
          Таиланда.
        </p>

        <p>
          Мы предоставляем полный спектр услуг — от
          продажи и аренды недвижимости, инвестиционных
          консультаций и юридического сопровождения до
          комплексной поддержки после завершения сделки,
          обеспечивая для каждого клиента комфортный,
          прозрачный и профессиональный сервис.
        </p>
      </div>

    </div>
  </div>
</section>

{{-- SERVICES / BENEFITS (match screenshot) --}}
<section id="invest" class="bg-[#f3f3f3] scroll-mt-24">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5">

    {{-- TOP HEAD --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-10">
      <div>
        <h2 class="text-[#2f343a] font-bold uppercase leading-[1.05]
                   text-[34px] sm:text-[42px]">
          ВАШ ДОМ<br>
          ВДАЛИ ОТ ДОМА
        </h2>
        <div class="mt-10 text-[20px] tracking-[.25em] uppercase text-[#7a8794]">
          все для вас
        </div>
      </div>

      <div class="md:text-right">
        <div class="block font-['Bicubik'] text-[#2da9e0] font-bold tracking-tight text-center
                    text-[44px] sm:text-[52px] leading-none">
          20+
        </div>
        <div class="mt-2 text-[#7a8794] text-[20px]">
          больше 20 проектов для вас
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
            ТРАНСФЕР
          </div>
          <p class="mt-4 text-[#7a8794] text-[15px] leading-relaxed">
            заберем вас от аэропорта и довезем до отеля,<br class="hidden sm:block">
            заберем вас от отеля на экскурсию по объектам
          </p>
        </div>
      </div>

      {{-- 2 --}}
      <div class="text-center">
        <img src="{{ asset('assets/icon/hand.png') }}" alt="Lawyer"
             class="mx-auto h-24 sm:h-28 w-auto opacity-90">
        <div class="mt-6 bg-white px-8 py-7 min-h-[200px] flex flex-col justify-start">
          <div class="block font-['Bicubik'] text-[#2da9e0] font-semibold uppercase tracking-[.18em] text-[20px]">
            ЮРИСТ
          </div>
          <p class="mt-4 text-[#7a8794] text-[15px] leading-relaxed">
            юридические консультации, оформление документов и
            сопровождение на всех этапах
          </p>
        </div>
      </div>

      {{-- 3 --}}
      <div class="text-center">
        <img src="{{ asset('assets/icon/mondy.png') }}" alt="Profit"
             class="mx-auto h-24 sm:h-28 w-auto opacity-90">
        <div class="mt-6 bg-white px-8 py-7 min-h-[200px] flex flex-col justify-start">
          <div class="block font-['Bicubik'] text-[#2da9e0] font-semibold uppercase tracking-[.18em] text-[20px]">
            ВЫГОДА
          </div>
          <p class="mt-4 text-[#7a8794] text-[15px] leading-relaxed">
            подберем для вас лучшее предложение
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
      ИНВЕСТИЦИИ
    </h2>

    <p class="mt-2 text-[#7a8794] max-w-2xl leading-snug text-[20px]">
      Инвестиции в недвижимость на Пхукете<br>
      могут приносить доход до <span class="font-semibold text-[#2f343a]">8% в год</span> от аренды
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
          class="w-full h-full object-cover"
        />
      </div>

      {{-- Right column (fill same height, stats pinned bottom) --}}
      <div class="flex flex-col h-full">

        {{-- TEXT --}}
        <p class="text-[#7a8794] leading-relaxed max-w-xl text-[20px]">
          Учитывая спрос со стороны туристов, аренда домов в премиальных проектах
          является не только стабильным источником дохода, но и способом извлечь
          выгоду из растущего интереса к недвижимости Пхукета.
        </p>

        {{-- STATS (pinned to bottom on desktop) --}}
        <div class="mt-6 lg:mt-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

          <div class="bg-white border border-black/5 p-4 sm:p-5 text-center min-w-0">
            <div class="font-display text-[#2da9e0] font-bold text-[22px] leading-none">8%</div>
            <div class="mt-2 text-[#7a8794] text-[14px] leading-snug break-words">
              Ожидаемая высокая доходность
            </div>
          </div>

          <div class="bg-white border border-black/5 p-4 sm:p-5 text-center min-w-0">
            <div class="font-display text-[#2da9e0] font-bold text-[22px] leading-none">15%</div>
            <div class="mt-2 text-[#7a8794] text-[14px] leading-snug break-words">
              Ожидаемый рост цены на 15% до завершения строительства кондоминиума
            </div>
          </div>

          <div class="bg-white border border-black/5 p-4 sm:p-5 text-center min-w-0">
            <div class="font-display text-[#2da9e0] font-bold text-[20px] leading-none">
              3.3 МЛН<br>БАТ
            </div>
            <div class="mt-2 text-[#7a8794] text-[14px] leading-snug break-words">
              Начальная цена от 3 300 000 бат
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
            Прирост стоимости недвижимости
          </div>
          <p class="mt-1 text-[#7a8794] text-[15px] leading-relaxed max-w-2xl">
            Годовой рост 13-16% благодаря увеличению стоимости недвижимости. Покупайте заранее для максимальных
            возможностей получения прибыли.
          </p>
        </div>

        <div class="text-right">
          <div class="font-bold text-[40px] tracking-tight">
            <span class="block font-['Bicubik'] text-[#2da9e0]">13–16%</span>
            <span class="block font-['Bicubik'] text-[#2f343a] uppercase">в год</span>
          </div>
        </div>
      </div>
    </div>

    {{-- Bottom info bar --}}
    <div class="mt-6 bg-white border border-black/5">
      <div class="h-[4px] w-36 bg-[#2da9e0]"></div>

      <div class="grid lg:grid-cols-[1fr_360px] gap-10 px-6 py-6 items-center">
        <div>
          <div class="text-[20px] font-semibold text-[#2f343a]">Рост</div>
          <p class="mt-1 text-[#7a8794] text-[15px] leading-relaxed max-w-2xl">
            Профессиональные управляющие компании гарантируют надежное управление и уход за недвижимостью.
            Распределение доходов составляет 80% владельца, что обеспечивает максимальную арендную доходность
          </p>
        </div>

        <div class="text-right">
          <div class="font-bold tracking-tight">
            <div class="block font-['Bicubik'] text-[#2da9e0] text-[40px] leading-none">80/20</div>
            <div class="block font-['Bicubik'] text-[#2f343a] uppercase text-[25px]">в пользу владельцев</div>
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
      ЭКСКЛЮЗИВНЫЕ ПРЕИМУЩЕСТВА<br>
      ДЛЯ ИНВЕСТОРОВ
    </h2>

    <div class="mt-10 space-y-8">

      {{-- Row 1: text left / image right --}}
      <div class="bg-white border border-black/5">
        <div class="grid lg:grid-cols-2 items-stretch">
          <div class="p-10 flex items-center">
            <div>
              <div class="text-[#6b7280] font-semibold text-[25px]">
                Привлекательная<br>инвестиционная возможность
              </div>
              <div class="mt-2 text-[#7a8794] text-[20px]">
                Ожидаемая доходность до 8% в год.
              </div>
            </div>
          </div>

          <div class="overflow-hidden">
            <img
              src="{{ asset('assets/investment/2.jpg') }}"
              alt="Advantage 1"
              class="w-full h-full object-cover"
            />
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
              class="w-full h-full object-cover"
            />
          </div>

          <div class="p-10 flex items-center">
            <div>
              <div class="text-[#6b7280] font-semibold text-[25px]">
                Премиальные материалы и<br>современные технологии
              </div>
              <div class="mt-2 text-[#7a8794] text-[20px] leading-relaxed max-w-xl">
                Отобранные проекты с акцентом на экологические инновации, систему умного дома,
                импортную мебель и бытовую технику международного стандарта
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
                  Рост цены до 40% к моменту<br>передачи ключей
                </span>
              </div>
            </div>
          </div>

          <div class="overflow-hidden">
            <img
              src="{{ asset('assets/investment/4.jpg') }}"
              alt="Advantage 3"
              class="w-full h-full object-cover"
            />
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
      ПРОЕКТЫ
    </h2>

    @php
      $projects = [
        [
          'badge' => '1-2 спальни',
          'title' => 'BALCONY Naiyang',
          'price' => 'от 5.4 млн БАТ',
          'desc'  => 'Balcony — Naiyang — курортный кондоминиум в тихом районе рядом с пляжем и международным аэропортом Пхукета. Проект сочетает близость к природе с современным комфортом и инвестиционной привлекательностью. Комплекс выполнен в стиле тропического курорта и предлагает зелёные зоны, бассейн и стиль лаунж общественные пространства, созданные для спокойного и расслабленного образа жизни.',
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
          'badge' => '1-2 спальни',
          'title' => 'VIBE RESIDENCE Karon',
          'price' => 'от 5.4 млн БАТ',
          'desc'  => 'Vibe Residence — Karon — курортная роскошь всего в 200 метрах от пляжа в самом центре динамичного района Карон. Проект расположен в непосредственной близости от пляжа Карон, парка и самых оживлённых мест Пхукета, предлагая высокий уровень комфорта, удобства и приближённого образа жизни. Удобное транспортное сообщение с Патонгом и центром города.',
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
          'badge' => '1-2 спальни',
          'title' => 'HALO 1 Naiyang',
          'price' => 'от 5.13 млн БАТ',
          'desc'  => 'The Halo 1 — Naiyang — курортный кондоминиум, сочетающий приватность, спокойствие и гармонию с природой. Зелёное окружение и продуманные общественные зоны создают атмосферу уединения и отдыха.
Архитектура с характерными двускатными крышами и элегантным Skin Façade, вдохновлённым наследием Пхукета, объединяет современный дизайн и местный колорит.',
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
          'badge' => '1-2 спальни',
          'title' => 'HERITAGE Bang-Tao',
          'price' => 'от 5.4 млн БАТ',
          'desc'  => 'Heritage — Bang-Tao — курортный кондоминиум в престижном районе рядом с Boat Avenue, Porto de Phuket и Laguna Phuket, выполненный в современном стиле с сино-элементами.
Развитая инфраструктура, близость пляжей Бангтао, Сурин и Лаян (5–10 минут) и удобный доступ к аэропорту Пхукета (около 35 минут) делают проект отличным выбором для жизни и инвестиций.',
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
          'badge' => '1-2 спальни',
          'title' => 'LEGENDARY Bang-Tao',
          'price' => 'от 6.8 млн БАТ',
          'desc'  => 'Legendary — Bang-Tao — современный жилой проект в престижном районе Бангтао, всего в нескольких минутах от пляжа и рядом с инфраструктурой и комплексом Laguna Phuket.
Проект сочетает стильные интерьеры и более 35 удобств курортного уровня, включая бассейны, фитнес-центр, клубный дом, коворкинг и детские зоны, предлагая комфортный образ жизни и инвестиционную привлекательность.',
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
          'badge' => '1-2 спальни',
          'title' => 'SERENITY Naiyang',
          'price' => 'от 3.4 млн БАТ',
          'desc'  => 'Serenity — Naiyang — современный курортный кондоминиум рядом с аэропортом Пхукета и северными пляжами острова. Проект сочетает стильный дизайн, комфорт и удобное расположение.
Комплекс предлагает развитую инфраструктуру для отдыха: бассейны, фитнес-центр, спа-зоны, онсэн и пространства для досуга. Пляж Найянг находится всего в 5 минутах, а рестораны, магазины и рынок — в шаговой доступности.',
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
          'badge' => '1-2 спальни',
          'title' => 'MODEVA Bang-Tao',
          'price' => 'от 4.7 млн БАТ',
          'desc'  => 'Modeva — Bang-Tao — стильный тропический проект с морской концепцией, где здания окружены извилистыми бассейнами и зелёным центральным пространством, создающим атмосферу уединённого острова.
Комплекс предлагает курортную инфраструктуру, включая бассейны, фитнес, онсэн, коворкинг, детские и общественные зоны, и расположен в пешей доступности от пляжа Бангтао, что делает его привлекательным для жизни и инвестиций.',
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
          'badge' => '1-2 спальни',
          'title' => 'CIELO Rawai',
          'price' => 'от 4.8 млн БАТ',
          'desc'  => 'Cielo — Rawai — премиальный прибрежный кондоминиум на юге Пхукета, в районе, известном своими живописными пейзажами и впечатляющими закатами. Раваи сочетает активный образ жизни с атмосферой уюта и аутентичного местного колорита.
Проект гармонично объединяет современную архитектуру и природную красоту побережья, предлагая комфортное проживание и высокий инвестиционный потенциал.',
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
          'badge' => '1-2 спальни',
          'title' => 'ARTRIO BangTao',
          'price' => 'от 4.3 млн БАТ',
          'desc'  => 'Artrio — Bang-Tao — проект надёжного застройщика в самом центре Бангтао, рядом с Porto de Phuket, Boat Avenue и комплексом Laguna Phuket.
Проект предлагает современные резиденции с продуманными планировками и подходит как для комфортного проживания, так и для инвестиций. Вся ключевая инфраструктура находится в шаговой доступности, а пляжи Бангтао, Сурин и Лаян — всего в 10 минутах.',
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
          'badge' => '1-2 спальни',
          'title' => 'KATABELLO Kata',
          'price' => 'от 4.2 млн БАТ',
          'desc'  => 'Katabello — Kata — курортный кондоминиум в центре Каты с развитой инфраструктурой и условиями для проживания с домашними животными.
Комплекс окружён бассейнами в стиле каналов и предлагает лаунж-зоны, кафе и специализированную pet-friendly инфраструктуру. Удобное расположение делает проект привлекательным как для комфортной жизни, так и для арендных инвестиций.',
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
          'badge' => '1-2 спальни',
          'title' => 'ADORA Rawai',
          'price' => 'от 5.3 млн БАТ',
          'desc'  => 'Adora — Rawai — современный тропический проект с акцентом на комфорт, приватность и функциональные планировки.
Расположен на юге Пхукета, рядом с пляжами Раваи и Най Харн и ключевыми локациями района, что делает проект подходящим как для жизни, так и для инвестиций с хорошим арендным потенциалом.
Проект идеален для спокойного проживание.',
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
          'badge' => '1-2 спальни',
          'title' => 'SIERRA Bang-Tao',
          'price' => 'от 2.9 млн БАТ',
          'desc'  => 'Sierra — Bang-Tao — современный жилой проект от надёжного застройщика в центре Ченг Талей, рядом с Porto de Phuket, Boat Avenue и комплексом Laguna Phuket.
Проект предлагает курортную инфраструктуру, включая бассейн на крыше, фитнес-центр, коворкинг, pet-зону и круглосуточную охрану. Пляжи Бангтао, Сурин и Лаян находятся в 10–15 минутах , а аэропорт Пхукета — в 35 минутах.',
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
          'badge' => '1-2 спальни',
          'title' => 'VILLA KIRARA Bang-Tao',
          'price' => 'от 29 млн БАТ',
          'desc'  => 'Villa Kirara — Bang-Tao — современный проект вилл с частными бассейнами, расположенный в тихом предгорном районе Ченг Талей, рядом с HeadStart International School, Boat Avenue, Laguna Phuket и пляжами Бангтао, Сурин и Лаян.
Проект из 37 стильных вилл с частными бассейнами и озеленёнными территориями. Спокойная атмосфера и удобная локация это отличный выбор для семейного отдыха и инвестиций.',
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
          'badge' => '1-2 спальни',
          'title' => 'CORALINA Kamala',
          'price' => 'от 4.7 млн БАТ',
          'desc'  => 'Coralina — Kamala — современный pet-friendly кондоминиум в престижном районе Камала, всего в 10 минутах от пляжа. Проект подходит как для проживания, так и для инвестиций.
Комплекс располагает курортной инфраструктурой: бассейнами, фитнес и йога-зонами, спа, детскими и pet-зонами, коворкингом и круглосуточной охраной. Удобное расположение обеспечивает быстрый доступ к центру Камалы, Патонгу и комплексу Laguna Phuket.',
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
            <div class="md:col-span-2 order-2 md:order-1 p-6 sm:p-7 md:p-8">
              <div class="text-[#2da9e0] font-semibold text-sm">
                {{ $p['badge'] }}
              </div>

              <div class="mt-2 text-[26px] md:text-[28px] leading-tight font-semibold text-[#222]">
                {{ $p['title'] }}
              </div>

              <div class="mt-2 text-[#2da9e0] font-bold">
                {{ $p['price'] }}
              </div>

              <p class="mt-4 text-[#6b7280] text-sm leading-relaxed">
                {{ $p['desc'] }}
              </p>

              {{-- CTA (works like old "Получить детали и цены") --}}
              <button
                class="w-full sm:w-auto mt-6 inline-flex items-center justify-center px-5 py-2.5 bg-[#2da9e0] text-white font-semibold hover:brightness-110 transition"
                x-data
                @click="$dispatch('open-lead', { project: @js($p['title']) })"
              >
                подробнее
              </button>
            </div>

            {{-- RIGHT: image slider --}}
              <div
                class="md:col-span-3 order-1 md:order-2 relative"
                x-data="{
                  images: {{ json_encode($p['images']) }},
                  index: 0,
                  next(){ this.index = (this.index + 1) % this.images.length },
                  prev(){ this.index = (this.index - 1 + this.images.length) % this.images.length }
                }"
              >
              <div class="relative h-[300px] sm:h-[360px] md:h-[360px] lg:h-[450px] overflow-hidden">
                <template x-for="(img, i) in images" :key="i">
                  <img
                    x-show="index === i"
                    x-transition.opacity.duration.250ms
                    :src="`{{ asset('assets/projects') }}/${img}`"
                    class="absolute inset-0 w-full h-full object-cover"
                    alt=""
                  >
                </template>

               <!-- overlay (ช่วยให้ลูกศร/จุดอ่านง่ายขึ้น) -->
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
                  aria-label="Prev"
                >
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
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
                  aria-label="Next"
                >
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
                <!-- dots (ไข่ปลา) -->
                <div class="absolute left-1/2 -translate-x-1/2 bottom-4 flex items-center gap-2">
                  <template x-for="(img, i) in images" :key="i">
                    <button
                      @click="index = i"
                      class="h-2.5 w-2.5 rounded-full transition
                            border border-white/40"
                      :class="index === i ? 'bg-[#2da9e0] scale-110' : 'bg-white/30 hover:bg-white/50'"
                      aria-label="Go to slide"
                    ></button>
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
          КОНТАКТЫ
        </h2>

        {{-- Address --}}
        <div class="mt-8">
          <div class="text-sm font-semibold tracking-widest uppercase text-white/80">
            Адрес
          </div>
          <p class="mt-2 text-white/70 leading-relaxed">
            Phuket Office<br>
            24/3 Moo 7, Chaofa Road,<br>
            T. Chalong, A. Muang Phuket, Phuket
          </p>
        </div>

        {{-- Phone --}}
        <div class="mt-6">
          <div class="text-sm font-semibold tracking-widest uppercase text-white/80">
            Телефон
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
            Соц сети
          </div>

          <div class="mt-3 flex gap-4">
            {{-- Telegram --}}
            <a href="https://t.me/sanbadarus" target="_blank"
               class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9.04 15.43l-.39 5.47c.56 0 .8-.24 1.09-.53l2.62-2.5 5.43 3.97c1 .55 1.72.26 1.98-.92l3.6-16.9c.34-1.57-.57-2.19-1.55-1.83L1.57 9.3c-1.52.6-1.5 1.45-.28 1.82l5.87 1.83L19.8 5.7c.6-.36 1.15-.16.7.24"/>
              </svg>
            </a>

            {{-- Facebook --}}
            <a href="https://www.facebook.com/profile.php?id=61579230497512" target="_blank"
               class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.75-1.6 1.52V12H16l-.5 3h-2.6v7A10 10 0 0022 12z"/>
              </svg>
            </a>

            {{-- Instagram --}}
            <a href="https://www.instagram.com/sanbadarealestate_rus/" target="_blank"
               class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm5 5a5 5 0 110 10 5 5 0 010-10zm6.5-.75a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0z"/>
              </svg>
            </a>

            {{-- WhatsApp --}}
            <a href="https://wa.me/qr/6XR54RUL5U25N1" target="_blank"
               class="h-10 w-10 flex items-center justify-center rounded-md bg-white/10 hover:bg-[#2da9e0] transition">
              <svg class="h-5 w-5" viewBox="0 0 32 32" fill="currentColor">
                <path d="M16.02 3C9.39 3 4 8.38 4 15.01c0 2.64.86 5.18 2.35 7.25L4 29l6.98-2.28a11.94 11.94 0 005.04 1.11h.01c6.62 0 12-5.38 12-12.01C28.03 8.38 22.64 3 16.02 3z"/>
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
            src="https://www.google.com/maps?q=7.840077,98.335495&z=16&output=embed"
            class="w-full h-full border-0"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>

        {{-- bottom nav under map --}}
        <div class="mt-6 flex flex-wrap gap-6 justify-end text-sm tracking-wide text-white/60">
          <a href="{{ route('home') }}" class="hover:text-white">НАВЕРХ</a>
          <a href="#about" class="hover:text-white">О НАС</a>
          <a href="#projects" class="hover:text-white">ПРОЕКТЫ</a>
          <a href="#invest" class="hover:text-white">ИНВЕСТИЦИИ</a>
        </div>
      </div>

    </div>
  </div>
</section>



  </main>

  {{-- MODAL --}}
  <div
    x-data="{ open: false }"
    @open-lead.window="open = true"
    @keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50"
  >
{{-- overlay --}}
<div
  class="fixed inset-0 z-50 bg-black/70 backdrop-blur-[2px]"
  @click="open=false"
></div>

{{-- modal wrapper (centering + safe on mobile) --}}
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
  {{-- modal box --}}
  <div
    class="relative w-full max-w-5xl overflow-hidden rounded-2xl sm:rounded-3xl bg-white shadow-2xl"
    style="box-shadow: 0 20px 80px rgba(0,0,0,.55);"
    @click.stop
  >
    {{-- top bar --}}
    <div class="flex items-center justify-between px-5 sm:px-8 py-4 border-b border-black/10 bg-white">
      <div class="text-sm sm:text-base font-semibold text-[#111]">
        Sanbada Real Estate
      </div>

      <button
        class="h-10 w-10 rounded-full bg-black/5 hover:bg-black/10 text-black/60 hover:text-black flex items-center justify-center transition"
        @click="open=false"
        aria-label="Close"
      >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
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
            Спецпредложение
          </div>

          <h2 class="mt-3 text-2xl sm:text-3xl font-extrabold leading-tight text-[#111]">
            Специальные условия действуют только до конца месяца,
            а лучшие объекты разлетаются быстро!
          </h2>

          <p class="mt-5 font-semibold text-[#111]">
            Мы подготовим для вас:
          </p>

          <ul class="mt-3 space-y-2 text-[#334155]">
            <li class="flex gap-2">
              <span class="mt-[6px] h-1.5 w-1.5 rounded-full bg-[#2da9e0]"></span>
              <span>Персональную консультацию</span>
            </li>
            <li class="flex gap-2">
              <span class="mt-[6px] h-1.5 w-1.5 rounded-full bg-[#2da9e0]"></span>
              <span>Индивидуальную подборку объектов</span>
            </li>
            <li class="flex gap-2">
              <span class="mt-[6px] h-1.5 w-1.5 rounded-full bg-[#2da9e0]"></span>
              <span>Полное сопровождение на каждом этапе покупки</span>
            </li>
          </ul>

          <div class="mt-6 rounded-xl border border-black/10 bg-white p-4 text-sm text-black/60">
            Получите лучшее предложение и поддержку от наших экспертов!
          </div>
        </div>

        {{-- right form --}}
        <div class="p-6 sm:p-8 md:p-10">
          <form method="POST" action="{{ route('lead.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="source" value="website">

            {{-- WhatsApp --}}
            <div>
              <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">
                Номер WhatsApp
              </label>

              <div class="mt-2 grid grid-cols-[110px_1fr] gap-2">
                <select
                  name="whatsapp_country"
                  class="h-12 rounded-xl border border-black/15 bg-white px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15"
                >
                  <option value="+66">+66</option>
                  <option value="+7">+7</option>
                  <option value="+48">+48</option>
                  <option value="+1">+1</option>
                </select>

                <input
                  name="whatsapp_phone"
                  required
                  inputmode="tel"
                  placeholder="Введите телефон *"
                  class="h-12 rounded-xl border border-black/15 px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15"
                >
              </div>

              @error('whatsapp_phone')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
              @enderror
            </div>

            {{-- Email --}}
            <div>
              <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">
                Введите email
              </label>

              <input
                name="email"
                type="email"
                placeholder="mail@example.com"
                class="mt-2 h-12 w-full rounded-xl border border-black/15 px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15"
              >

              @error('email')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
              @enderror
            </div>

            {{-- Name --}}
            <div>
              <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">
                Введите имя
              </label>

              <input
                name="name"
                placeholder="Имя"
                class="mt-2 h-12 w-full rounded-xl border border-black/15 px-3 outline-none focus:border-[#2da9e0] focus:ring-4 focus:ring-[#2da9e0]/15"
              >
            </div>

            {{-- Submit --}}
            <button
              class="mt-2 h-12 w-full rounded-full bg-[#2da9e0] text-white font-semibold hover:brightness-110 transition"
            >
              Получить подборку
            </button>

            {{-- consent --}}
            <label class="flex gap-3 items-start text-sm text-black/60">
              <input
                name="consent"
                type="checkbox"
                value="1"
                required
                class="mt-1 h-4 w-4 rounded border-black/20 text-[#2da9e0] focus:ring-[#2da9e0]/30"
              >
              <span>
                Я соглашаюсь на обработку персональных данных согласно
                <a class="text-[#2da9e0] underline hover:opacity-80" href="{{ route('privacy') }}">
                  политике конфиденциальности
                </a>
              </span>
            </label>

            @error('consent')
              <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
          </form>

          <div class="mt-6 text-xs text-black/40">
            После отправки мы свяжемся с вами в WhatsApp.
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


  <!-- Marquiz Widget Code (put before </body>) -->
  <script>
  (function(t, p) {
    window.Marquiz
      ? Marquiz.add([t, p])
      : document.addEventListener('marquizLoaded', function() {
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
