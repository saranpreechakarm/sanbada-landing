<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thailand Villa Center</title>

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

<body class="bg-black text-white">

  {{-- NAVBAR --}}
  <header class="sticky top-0 z-40 bg-black/70 backdrop-blur border-b border-yellow-500/15">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between gap-6">
      {{-- Brand --}}
      <a href="{{ route('home') }}" class="flex items-center gap-3">
        <img src="{{ asset('assets/brand/logo-gold.png') }}" alt="Sanbada Real Estate" class="h-8 w-auto">
        <div class="leading-tight">
          <div class="font-semibold tracking-wide">
            <span class="text-blue-400">SANBADA</span>
            <span class="text-white/80">REAL ESTATE</span>
          </div>
          <div class="text-xs text-white/50">Phuket Property • Premium Deals</div>
        </div>
      </a>

      {{-- Menu (optional) --}}
      <nav class="hidden md:flex items-center gap-6 text-sm text-white/70">
        <a href="#projects" class="hover:text-white">Проекты</a>
        <a href="#deals" class="hover:text-white">Скидки</a>
        <a href="#contacts" class="hover:text-white">Контакты</a>
      </nav>

      {{-- Contact --}}
      <div class="flex items-center gap-3">
        <a class="hidden sm:flex items-center gap-2 text-white/70 hover:text-white"
           href="https://wa.me/66653489444">
          <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-green-500/15 border border-green-500/30">
            {{-- WhatsApp icon (simple) --}}
            <svg viewBox="0 0 32 32" class="h-5 w-5 fill-green-400"><path d="M19.11 17.22c-.27-.14-1.6-.79-1.85-.88-.25-.09-.43-.14-.61.14-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.14-1.16-.43-2.2-1.36-.81-.72-1.36-1.6-1.52-1.87-.16-.27-.02-.41.12-.55.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.53-.44-.46-.61-.47h-.52c-.18 0-.48.07-.73.34-.25.27-.96.94-.96 2.3 0 1.36.98 2.67 1.11 2.86.14.18 1.93 2.95 4.68 4.13.66.29 1.18.46 1.58.59.66.21 1.27.18 1.75.11.53-.08 1.6-.65 1.83-1.28.23-.63.23-1.17.16-1.28-.07-.11-.25-.18-.52-.32z"/><path d="M16.02 3C9.39 3 4 8.39 4 15.02c0 2.12.55 4.11 1.52 5.84L4 29l8.33-1.45a11.94 11.94 0 0 0 3.69.58c6.63 0 12.02-5.39 12.02-12.02C28.04 8.39 22.65 3 16.02 3zm0 22.1c-1.2 0-2.38-.2-3.49-.61l-.5-.18-4.94.86.9-4.81-.21-.52a10.05 10.05 0 0 1-0.8-3.82c0-5.55 4.51-10.06 10.06-10.06s10.06 4.51 10.06 10.06-4.51 10.08-10.06 10.08z"/></svg>
          </span>
          <span class="font-medium">WhatsApp</span>
        </a>

        <a class="text-white/70 hover:text-white font-medium"
           href="tel:+66653489444">+66 653 489 444</a>

        <button class="px-4 py-2 rounded-lg bg-blue-400 text-black font-semibold hover:bg-blue-500"
                x-data @click="$dispatch('open-lead')">
          Получить подборку
        </button>
      </div>
    </div>
  </header>

  {{-- MAIN --}}
  <main>
    {{-- HERO FULLSCREEN --}}
    <section class="relative min-h-[100svh] flex items-center">
      {{-- BG IMAGE --}}
      <img
        src="{{ asset('assets/hero/hero-01.jpg') }}"
        alt="Sanbada Hero"
        class="absolute inset-0 h-full w-full object-cover"
      />

      {{-- OVERLAY --}}
      <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/35 to-black/80"></div>

      {{-- CONTENT --}}
      <div class="relative w-full">
        <div class="max-w-6xl mx-auto px-4 pt-24 pb-14">
          <div class="mx-auto max-w-5xl rounded-[44px] md:rounded-[56px] overflow-hidden border border-yellow-500/15 bg-black/35 backdrop-blur"
               style="box-shadow: 0 30px 90px rgba(0,0,0,.55);">
            <div class="px-6 md:px-16 py-14 md:py-16 text-center">
              <h1 class="text-3xl md:text-5xl font-bold leading-tight">
                Готовые апартаменты на Пхукете
                <br class="hidden md:block">
                <span class="text-yellow-400">в чёрно-золотом стиле от Sanbada Real Estate</span>
              </h1>

              <p class="mt-5 text-white/85 text-base md:text-xl">
                Лучшие предложения • Подборка под ваш бюджет • Связь через WhatsApp
              </p>

              <p class="mt-3 text-white/60 text-sm md:text-base">
                Спец-условия действуют ограниченное время — оставьте заявку и получите подборку.
              </p>

              <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button
                  class="px-7 py-3 rounded-full bg-blue-400 text-black font-semibold hover:bg-blue-500"
                  x-data @click="$dispatch('open-lead')"
                >
                  Скачать каталог / Получить подборку
                </button>

                <a
                  class="px-7 py-3 rounded-full border border-yellow-500/35 text-white/90 hover:border-yellow-500"
                  href="https://wa.me/66653489444"
                >
                  Написать в WhatsApp
                </a>
              </div>

              <div class="mt-6 text-xs text-white/50">
                Нажимая кнопку, вы соглашаетесь с
                <a class="underline hover:text-yellow-400" href="{{ route('privacy') }}">политикой конфиденциальности</a>
              </div>
            </div>
          </div>

          {{-- scroll hint --}}
          <div class="mt-8 flex justify-center">
            <a href="#benefits" class="text-white/60 hover:text-white text-sm">
              ↓ Смотреть дальше
            </a>
          </div>
        </div>
      </div>
    </section>

    {{-- BENEFITS --}}
    <section id="benefits" class="bg-white text-black">
      <div class="max-w-6xl mx-auto px-4 py-16">
        <div class="grid md:grid-cols-3 gap-5">
          {{-- card --}}
          <div class="rounded-2xl bg-[#FFF7DB] p-6 border border-yellow-500/20">
            <div class="flex items-center gap-3">
              <span class="h-10 w-10 rounded-xl bg-yellow-500/20 flex items-center justify-center text-yellow-700">%</span>
              <div class="font-semibold">Скидки до 30% и другие бонусы</div>
            </div>
          </div>

          <div class="rounded-2xl bg-[#FFF7DB] p-6 border border-yellow-500/20">
            <div class="flex items-center gap-3">
              <span class="h-10 w-10 rounded-xl bg-yellow-500/20 flex items-center justify-center text-yellow-700">🛠</span>
              <div class="font-semibold">Ремонт и мебель в подарок</div>
            </div>
          </div>

          <div class="rounded-2xl bg-[#FFF7DB] p-6 border border-yellow-500/20">
            <div class="flex items-center gap-3">
              <span class="h-10 w-10 rounded-xl bg-yellow-500/20 flex items-center justify-center text-yellow-700">💎</span>
              <div class="font-semibold">Уникальные юниты в проектах</div>
            </div>
          </div>
        </div>

        {{-- ABOUT --}}
        <div class="mt-14 grid lg:grid-cols-2 gap-10 items-center">
          <div>
            <h2 class="text-3xl md:text-4xl font-bold leading-tight">
              Sanbada Real Estate —
              <br>
              ваш <span class="text-yellow-600">надёжный партнёр</span>
              <br>
              по недвижимости на Пхукете
            </h2>

            <p class="mt-5 text-black/70 leading-relaxed">
              Мы сотрудничаем с ведущими застройщиками и агентствами, что даёт доступ к эксклюзивным предложениям,
              а также помогает подобрать объект под ваш бюджет и цели — для жизни или инвестиций.
            </p>

            <div class="mt-7 flex flex-wrap gap-3">
              <button class="px-6 py-3 rounded-xl bg-black text-white font-semibold hover:opacity-90"
                      x-data @click="$dispatch('open-lead')">
                Получить подборку
              </button>
              <a class="px-6 py-3 rounded-xl border border-black/15 hover:border-black/30"
                 href="https://wa.me/66653489444">
                Связаться в WhatsApp
              </a>
            </div>
          </div>

          <div class="rounded-[28px] overflow-hidden shadow-lg border border-black/10">
            <img src="{{ asset('assets/about/team.jpg') }}"
                 alt="Sanbada Team"
                 class="w-full h-[320px] md:h-[420px] object-cover">
          </div>
        </div>
      </div>
    </section>

    {{-- PROJECTS (image left, description right) --}}
    <section id="projects" class="bg-black text-white">
      <div class="max-w-6xl mx-auto px-4 py-20">

        <div class="max-w-3xl mb-14">
          <h2 class="text-3xl md:text-4xl font-bold">
            Проекты на Пхукете
            <span class="block text-yellow-400 mt-1">выберите и листайте фото</span>
          </h2>
          <p class="mt-4 text-white/70">
            В каждом проекте — 5 фото. Вы можете пролистать без перехода на отдельную страницу.
          </p>
        </div>

        @php
          $projects = [
            [
              'title' => 'Adora Rawai',
              'location' => 'Rawai, Phuket',
              'type' => 'Condominium • Ready / Investment',
              'price' => 'от 3,300,000฿',
              'highlights' => [
                '300 м до моря (пример)',
                'Ресорт-инфраструктура и бассейн',
                'Высокий спрос на аренду',
              ],
              'description' => 'Современный проект в популярном районе с удобной инфраструктурой. Подходит для личного проживания и инвестиций.',
              'images' => [
                'adora-rawai/1.jpg',
                'adora-rawai/2.jpg',
                'adora-rawai/3.jpg',
                'adora-rawai/4.jpg',
                'adora-rawai/5.jpg',
              ],
            ],
            [
              'title' => 'The Title Naiyang',
              'location' => 'Naiyang Beach',
              'type' => 'Condominium • Near Beach',
              'price' => 'от 3,900,000฿',
              'highlights' => [
                'Пешком до пляжа Naiyang',
                'Подходит для long-stay и аренды',
                'Надёжный девелопер (Title)',
              ],
              'description' => 'Уютный формат для отдыха и долгосрочного проживания. Отличная локация, высокий потенциал роста.',
              'images' => [
                'title-naiyang/1.jpg',
                'title-naiyang/2.jpg',
                'title-naiyang/3.jpg',
                'title-naiyang/4.jpg',
                'title-naiyang/5.jpg',
              ],
            ],
          ];
        @endphp

        <div class="space-y-16">

          @foreach ($projects as $project)
            <div class="border border-yellow-500/15 bg-[#0b0b0b]">
              <div class="grid lg:grid-cols-2">
                {{-- LEFT: IMAGE SLIDER (no rounded) --}}
                <div
                  class="relative"
                  x-data="{
                    images: {{ json_encode($project['images']) }},
                    index: 0
                  }"
                >
                  <div class="relative h-[360px] md:h-[520px] overflow-hidden">
                    <template x-for="(img, i) in images" :key="i">
                      <img
                        x-show="index === i"
                        x-transition.opacity.duration.300ms
                        :src="`{{ asset('assets/projects') }}/${img}`"
                        class="absolute inset-0 w-full h-full object-cover"
                        alt=""
                      >
                    </template>

                    {{-- overlay for readability --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/15 via-black/15 to-black/15"></div>

                    {{-- arrows --}}
                    <button
                      @click="index = (index === 0) ? images.length - 1 : index - 1"
                      class="absolute left-4 top-1/2 -translate-y-1/2 h-11 w-11 bg-black/60 border border-white/20 flex items-center justify-center hover:bg-black/80"
                      aria-label="Prev"
                    >
                      ‹
                    </button>

                    <button
                      @click="index = (index === images.length - 1) ? 0 : index + 1"
                      class="absolute right-4 top-1/2 -translate-y-1/2 h-11 w-11 bg-black/60 border border-white/20 flex items-center justify-center hover:bg-black/80"
                      aria-label="Next"
                    >
                      ›
                    </button>

                    {{-- counter --}}
                    <div class="absolute bottom-4 left-4 text-xs text-white/80 bg-black/55 px-3 py-1 border border-white/15">
                      <span x-text="index + 1"></span>/<span x-text="images.length"></span>
                    </div>
                  </div>

                  {{-- dots --}}
                  <div class="px-6 py-4 bg-black/60 border-t border-white/10">
                    <div class="flex gap-2">
                      <template x-for="(img, i) in images" :key="i">
                        <button
                          @click="index = i"
                          :class="index === i ? 'bg-yellow-400' : 'bg-white/30'"
                          class="h-2.5 w-2.5 transition"
                          aria-label="Dot"
                        ></button>
                      </template>
                    </div>
                  </div>
                </div>

                {{-- RIGHT: DESCRIPTION --}}
                <div class="p-8 md:p-10">
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <h3 class="text-2xl md:text-3xl font-semibold">
                        {{ $project['title'] }}
                      </h3>
                      <div class="mt-2 text-white/65">
                        {{ $project['location'] }} • <span class="text-yellow-400">{{ $project['type'] }}</span>
                      </div>
                    </div>

                    <div class="text-right">
                      <div class="text-xs text-white/50">Цена</div>
                      <div class="text-yellow-400 font-semibold">{{ $project['price'] }}</div>
                    </div>
                  </div>

                  <p class="mt-6 text-white/75 leading-relaxed">
                    {{ $project['description'] }}
                  </p>

                  <div class="mt-6">
                    <div class="text-sm font-semibold text-white/90">Ключевые преимущества:</div>
                    <ul class="mt-3 space-y-2 text-white/70">
                      @foreach ($project['highlights'] as $h)
                        <li class="flex gap-2">
                          <span class="text-yellow-400">•</span>
                          <span>{{ $h }}</span>
                        </li>
                      @endforeach
                    </ul>
                  </div>

                  {{-- CTA --}}
                  <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button
                      class="px-6 py-3 bg-yellow-500 text-black font-semibold hover:bg-yellow-400"
                      x-data
                      @click="$dispatch('open-lead')"
                    >
                      Получить детали и цены
                    </button>

                    <a
                      class="px-6 py-3 border border-yellow-500/35 text-white/90 hover:border-yellow-500"
                      href="https://wa.me/66653489444"
                    >
                      WhatsApp
                    </a>
                  </div>

                  <div class="mt-4 text-xs text-white/45">
                    Мы ответим в WhatsApp и отправим актуальные планировки и прайс.
                  </div>
                </div>
              </div>
            </div>
          @endforeach

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
    <div class="absolute inset-0 bg-black/70" @click="open=false"></div>

    {{-- modal box --}}
    <div class="relative mx-auto mt-10 max-w-5xl w-[95%] rounded-3xl overflow-hidden shadow-2xl"
         style="box-shadow: 0 20px 80px rgba(0,0,0,.6);">
      <button class="absolute top-4 right-4 text-white/70 hover:text-white" @click="open=false">✕</button>

      <div class="grid md:grid-cols-2 bg-white text-black">
        {{-- left content --}}
        <div class="p-10">
          <h2 class="text-3xl font-bold leading-tight">
            Специальные условия действуют только до конца месяца,
            а лучшие объекты разлетаются быстро!
          </h2>

          <p class="mt-6 font-semibold">Мы подготовим для вас:</p>
          <ul class="mt-3 space-y-2 text-black/70">
            <li>• Персональную консультацию</li>
            <li>• Индивидуальную подборку объектов</li>
            <li>• Полное сопровождение на каждом этапе покупки</li>
          </ul>

          <p class="mt-6 italic text-black/60">
            Получите лучшее предложение и поддержку от наших экспертов!
          </p>
        </div>

        {{-- right form --}}
        <div class="p-10 border-l border-black/10">
          <form method="POST" action="{{ route('lead.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="source" value="website">

            <div>
              <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">Номер WhatsApp</label>
              <div class="mt-2 grid grid-cols-[120px_1fr] gap-2">
                <select name="whatsapp_country"
                        class="h-12 rounded-lg border border-black/20 px-3 outline-none focus:border-yellow-500">
                  <option value="+66">+66</option>
                  <option value="+7">+7</option>
                  <option value="+48">+48</option>
                  <option value="+1">+1</option>
                </select>

                <input name="whatsapp_phone" required
                       placeholder="Введите телефон *"
                       class="h-12 rounded-lg border border-red-500/60 px-3 outline-none focus:border-yellow-500">
              </div>
              @error('whatsapp_phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">Введите email</label>
              <input name="email" type="email" placeholder="mail@example.com"
                     class="mt-2 h-12 w-full rounded-lg border border-black/20 px-3 outline-none focus:border-yellow-500">
              @error('email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-xs font-semibold tracking-wide text-black/60 uppercase">Введите имя</label>
              <input name="name" placeholder="Имя"
                     class="mt-2 h-12 w-full rounded-lg border border-black/20 px-3 outline-none focus:border-yellow-500">
            </div>

            <button class="mt-2 h-12 w-full rounded-full bg-[#C97B55] text-white font-semibold hover:opacity-90">
              Получить подборку
            </button>

            <label class="flex gap-2 items-start text-sm text-black/60">
              <input name="consent" type="checkbox" value="1" required class="mt-1">
              <span>
                Я соглашаюсь на обработку персональных данных согласно
                <a class="text-[#C97B55] underline" href="{{ route('privacy') }}">политике конфиденциальности</a>
              </span>
            </label>
            @error('consent') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
          </form>

          <div class="mt-6 text-xs text-black/40">
            После отправки мы свяжемся с вами в WhatsApp.
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
