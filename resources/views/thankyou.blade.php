<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Спасибо — Sanbada Real Estate</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#0b0b0b] text-white overflow-x-hidden">

  {{-- subtle background --}}
  <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-10">
    <div class="w-full max-w-xl rounded-3xl border border-white/10 bg-[#0f0f0f] shadow-[0_20px_80px_rgba(0,0,0,.45)] overflow-hidden">

      {{-- top accent --}}
      <div class="h-1.5 bg-[#2da9e0]"></div>

      <div class="p-8 sm:p-10 text-center">
        <div class="mx-auto mb-5 h-14 w-14 rounded-full bg-[#2da9e0]/15 flex items-center justify-center">
          <svg class="h-7 w-7 text-[#2da9e0]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <div class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
          Спасибо!
        </div>

        <p class="mt-3 text-white/65 leading-relaxed">
          Мы получили вашу заявку. Наш специалист свяжется с вами в ближайшее время.
        </p>

        <div class="mt-7 flex flex-col sm:flex-row gap-3 justify-center">
          <a href="{{ route('home') }}"
             class="px-6 py-3 rounded-xl bg-[#2da9e0] text-white font-semibold hover:brightness-110 transition">
            На главную
          </a>

          <a href="https://wa.me/66653489444"
             class="px-6 py-3 rounded-xl border border-white/15 text-white/85 hover:border-[#2da9e0] hover:text-white transition">
            Написать в WhatsApp
          </a>
        </div>

        <div class="mt-7 text-sm text-white/55">
          Телефон / WhatsApp:
          <a class="text-[#2da9e0] hover:underline" href="tel:+66653489444">+66 653 489 444</a>
        </div>

        <div class="mt-2 text-xs text-white/35">
          Sanbada Real Estate • Phuket
        </div>
      </div>
    </div>
  </div>

</body>
</html>
