<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Политика конфиденциальности — Sanbada Real Estate</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#0b0b0b] text-white overflow-x-hidden">

  {{-- HEADER (match site style) --}}
  <header class="sticky top-0 z-40 border-b border-white/10 bg-black/60 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
      <a href="{{ route('home') }}" class="font-semibold tracking-wide">
        <span class="text-white/80">SANBADA</span>
        <span class="text-[#2da9e0]">REAL ESTATE</span>
      </a>

      <a href="tel:+66653489444" class="text-white/60 hover:text-white transition">
        +66 653 489 444
      </a>
    </div>
  </header>

  {{-- MAIN --}}
  <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
    <div class="max-w-4xl">

      <div class="text-xs tracking-[.25em] uppercase text-white/45">
        Legal
      </div>

      <h1 class="mt-2 text-3xl md:text-4xl font-extrabold tracking-tight">
        Политика конфиденциальности
      </h1>

      <p class="mt-4 text-white/65 leading-relaxed">
        Настоящая Политика конфиденциальности описывает, как <strong class="text-white">Sanbada Real Estate</strong>
        («мы», «нас», «наш сервис») собирает, использует и защищает персональные данные пользователей сайта.
      </p>

      {{-- CONTENT CARD --}}
      <div class="mt-10 rounded-2xl border border-white/10 bg-[#0f0f0f] shadow-[0_20px_80px_rgba(0,0,0,.35)]">
        <div class="p-6 sm:p-8 md:p-10 space-y-8 text-white/80 leading-relaxed">

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">1. Какие данные мы собираем</h2>
            <p class="mt-2">
              Мы собираем только те данные, которые вы добровольно предоставляете через формы на сайте, включая:
            </p>
            <ul class="mt-3 list-disc pl-6 space-y-1 text-white/70">
              <li>номер WhatsApp (код страны и номер телефона);</li>
              <li>адрес электронной почты (если указан);</li>
              <li>имя (если указано);</li>
              <li>прочая информация, которую вы укажете в сообщении/заявке (если предусмотрено).</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">2. Цели обработки</h2>
            <p class="mt-2">Мы используем ваши данные для следующих целей:</p>
            <ul class="mt-3 list-disc pl-6 space-y-1 text-white/70">
              <li>связаться с вами по вашему запросу и предоставить подборку объектов недвижимости;</li>
              <li>предоставить консультацию по покупке/инвестициям/аренде недвижимости на Пхукете;</li>
              <li>улучшать качество сервиса и коммуникации с клиентами.</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">3. Правовое основание</h2>
            <p class="mt-2 text-white/70">
              Обработка данных осуществляется на основании вашего согласия (отметка в форме),
              а также в целях исполнения вашего запроса (обратный звонок/сообщение и подбор вариантов).
            </p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">4. Передача третьим лицам</h2>
            <p class="mt-2 text-white/70">
              Мы не продаём ваши персональные данные. Доступ к данным может быть предоставлен только:
            </p>
            <ul class="mt-3 list-disc pl-6 space-y-1 text-white/70">
              <li>нашим сотрудникам/представителям, отвечающим за обработку заявок;</li>
              <li>техническим подрядчикам (хостинг/поддержка), исключительно для обеспечения работы сайта;</li>
              <li>если это требуется законом или по запросу уполномоченных органов.</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">5. Срок хранения</h2>
            <p class="mt-2 text-white/70">
              Мы храним данные столько, сколько это необходимо для обработки запроса и последующей коммуникации,
              либо до момента отзыва согласия, если иное не требуется по закону.
            </p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">6. Безопасность данных</h2>
            <p class="mt-2 text-white/70">
              Мы применяем разумные организационные и технические меры для защиты данных от несанкционированного
              доступа, изменения или уничтожения.
            </p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">7. Ваши права</h2>
            <p class="mt-2 text-white/70">
              Вы можете запросить доступ к данным, их исправление или удаление, а также отозвать согласие на обработку.
              Для этого свяжитесь с нами любым удобным способом.
            </p>
          </section>

          {{-- CONTACT CARD --}}
          <section class="rounded-2xl border border-white/10 bg-black/40 p-6">
            <h2 class="text-xl font-semibold text-[#2da9e0]">Контакты</h2>
            <p class="mt-2 text-white/80">
              Sanbada Real Estate<br>
              Телефон / WhatsApp:
              <a class="text-[#2da9e0] hover:underline" href="tel:+66653489444">+66 653 489 444</a>
            </p>
            <p class="mt-2 text-white/45 text-sm">
              Дата обновления: {{ now()->format('d.m.Y') }}
            </p>
          </section>

        </div>
      </div>

      {{-- BACK --}}
      <div class="mt-10">
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 text-[#2da9e0] hover:opacity-80 transition">
          <span aria-hidden="true">←</span>
          Вернуться на главную
        </a>
      </div>

    </div>
  </main>

  {{-- FOOTER --}}
  <footer class="border-t border-white/10 bg-black/40">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 text-sm text-white/50 flex flex-col md:flex-row gap-2 justify-between">
      <div>© {{ date('Y') }} Sanbada Real Estate</div>
      <div>
        <a class="hover:text-white" href="{{ route('privacy') }}">Политика конфиденциальности</a>
      </div>
    </div>
  </footer>

</body>
</html>
