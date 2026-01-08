<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Политика конфиденциальности — Sanbada Real Estate</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-black text-white">

  <header class="border-b border-yellow-500/20">
    <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="{{ route('home') }}" class="font-semibold tracking-wide">
        <span class="text-yellow-400">SANBADA</span> <span class="text-white/80">REAL ESTATE</span>
      </a>
      <a href="tel:+66653489444" class="text-white/70 hover:text-white">+66 653 489 444</a>
    </div>
  </header>

  <main class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl md:text-4xl font-bold">Политика конфиденциальности</h1>
    <p class="mt-3 text-white/70">
      Настоящая Политика конфиденциальности описывает, как <strong>Sanbada Real Estate</strong>
      («мы», «нас», «наш сервис») собирает, использует и защищает персональные данные пользователей
      сайта.
    </p>

    <div class="mt-10 space-y-8 text-white/80 leading-relaxed">
      <section>
        <h2 class="text-xl font-semibold text-yellow-400">1. Какие данные мы собираем</h2>
        <p class="mt-2">
          Мы собираем только те данные, которые вы добровольно предоставляете через формы на сайте, включая:
        </p>
        <ul class="mt-2 list-disc pl-6 space-y-1">
          <li>номер WhatsApp (код страны и номер телефона);</li>
          <li>адрес электронной почты (если указан);</li>
          <li>имя (если указано);</li>
          <li>прочая информация, которую вы укажете в сообщении/заявке (если предусмотрено).</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-yellow-400">2. Цели обработки</h2>
        <p class="mt-2">
          Мы используем ваши данные для следующих целей:
        </p>
        <ul class="mt-2 list-disc pl-6 space-y-1">
          <li>связаться с вами по вашему запросу и предоставить подборку объектов недвижимости;</li>
          <li>предоставить консультацию по покупке/инвестициям/аренде недвижимости на Пхукете;</li>
          <li>улучшать качество сервиса и коммуникации с клиентами.</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-yellow-400">3. Правовое основание</h2>
        <p class="mt-2">
          Обработка данных осуществляется на основании вашего согласия (отметка в форме),
          а также в целях исполнения вашего запроса (обратный звонок/сообщение и подбор вариантов).
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-yellow-400">4. Передача третьим лицам</h2>
        <p class="mt-2">
          Мы не продаём ваши персональные данные. Доступ к данным может быть предоставлен только:
        </p>
        <ul class="mt-2 list-disc pl-6 space-y-1">
          <li>нашим сотрудникам/представителям, отвечающим за обработку заявок;</li>
          <li>техническим подрядчикам (хостинг/поддержка), исключительно для обеспечения работы сайта;</li>
          <li>если это требуется законом или по запросу уполномоченных органов.</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-yellow-400">5. Срок хранения</h2>
        <p class="mt-2">
          Мы храним данные столько, сколько это необходимо для обработки запроса и последующей коммуникации,
          либо до момента отзыва согласия, если иное не требуется по закону.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-yellow-400">6. Безопасность данных</h2>
        <p class="mt-2">
          Мы применяем разумные организационные и технические меры для защиты данных от несанкционированного
          доступа, изменения или уничтожения.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-yellow-400">7. Ваши права</h2>
        <p class="mt-2">
          Вы можете запросить доступ к данным, их исправление или удаление, а также отозвать согласие на обработку.
          Для этого свяжитесь с нами любым удобным способом.
        </p>
      </section>

      <section class="rounded-2xl border border-yellow-500/25 bg-white/5 p-6">
        <h2 class="text-xl font-semibold text-yellow-400">Контакты</h2>
        <p class="mt-2 text-white/80">
          Sanbada Real Estate<br>
          Телефон / WhatsApp: <a class="underline hover:text-yellow-400" href="tel:+66653489444">+66 653 489 444</a>
        </p>
        <p class="mt-2 text-white/60 text-sm">
          Дата обновления: {{ now()->format('d.m.Y') }}
        </p>
      </section>
    </div>

    <div class="mt-10">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-yellow-400 hover:text-yellow-300">
        ← Вернуться на главную
      </a>
    </div>
  </main>

  <footer class="border-t border-yellow-500/20">
    <div class="max-w-5xl mx-auto px-4 py-6 text-sm text-white/60 flex flex-col md:flex-row gap-2 justify-between">
      <div>© {{ date('Y') }} Sanbada Real Estate</div>
      <div><a class="hover:text-yellow-400" href="{{ route('privacy') }}">Политика конфиденциальности</a></div>
    </div>
  </footer>

</body>
</html>
