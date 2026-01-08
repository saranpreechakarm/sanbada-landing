<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Спасибо — Sanbada Real Estate</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-black text-white">

  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-lg rounded-3xl border border-yellow-500/25 bg-white/5 p-10 text-center">
      <div class="text-yellow-400 text-3xl font-bold">Спасибо!</div>
      <p class="mt-3 text-white/70">
        Мы получили вашу заявку. Наш специалист свяжется с вами в ближайшее время.
      </p>

      <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('home') }}"
           class="px-6 py-3 rounded-xl bg-yellow-500 text-black font-semibold hover:bg-yellow-400">
          На главную
        </a>
        <a href="https://wa.me/66653489444"
           class="px-6 py-3 rounded-xl border border-yellow-500/30 hover:border-yellow-500">
          Написать в WhatsApp
        </a>
      </div>

      <div class="mt-6 text-sm text-white/60">
        Телефон / WhatsApp: <a class="underline hover:text-yellow-400" href="tel:+66653489444">+66 653 489 444</a>
      </div>
    </div>
  </div>

</body>
</html>
