<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Политика конфиденциальности — Sanbada Real Estate</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#0b0b0b] text-white overflow-x-hidden">
  @php
  $locale = app()->getLocale(); // ru | en
  $segments = request()->segments();

  // remove locale prefix to keep current path when switching
  if (in_array($segments[0] ?? '', ['ru','en'])) array_shift($segments);
  $path = implode('/', $segments);

  $ruUrl = url('/ru' . ($path ? '/' . $path : ''));
  $enUrl = url('/en' . ($path ? '/' . $path : ''));
  @endphp
  {{-- HEADER (match site style) --}}
  <header class="sticky top-0 z-40 border-b border-white/10 bg-black/60 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
      <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="font-semibold tracking-wide">
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
        {{ __('Legal_1') }}
      </h1>
 
      <p class="mt-4 text-white/65 leading-relaxed">
       {{ __('Legal_2') }} <strong class="text-white">Sanbada Real Estate</strong>
      {{ __('Legal_3') }}
      </p>

      {{-- CONTENT CARD --}}
      <div class="mt-10 rounded-2xl border border-white/10 bg-[#0f0f0f] shadow-[0_20px_80px_rgba(0,0,0,.35)]">
        <div class="p-6 sm:p-8 md:p-10 space-y-8 text-white/80 leading-relaxed">

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_4') }}</h2>
            <p class="mt-2">
              {{ __('Legal_5') }}
            </p>
            <ul class="mt-3 list-disc pl-6 space-y-1 text-white/70">
              <li>{{ __('Legal_6') }}</li>
              <li>{{ __('Legal_7') }}</li>
              <li>{{ __('Legal_8') }}</li>
              <li>{{ __('Legal_9') }}</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_10') }}</h2>
            <p class="mt-2">{{ __('Legal_11') }}</p>
            <ul class="mt-3 list-disc pl-6 space-y-1 text-white/70">
              <li>{{ __('Legal_12') }}</li>
              <li>{{ __('Legal_13') }}</li>
              <li>{{ __('Legal_14') }}</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_15') }}</h2>
            <p class="mt-2 text-white/70">
              {{ __('Legal_16') }}
            </p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_17') }}</h2>
            <p class="mt-2 text-white/70">
              {{ __('Legal_18') }}
            </p>
            <ul class="mt-3 list-disc pl-6 space-y-1 text-white/70">
              <li>{{ __('Legal_19') }}</li>
              <li>{{ __('Legal_20') }}</li>
              <li>{{ __('Legal_21') }}</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_22') }}</h2>
            <p class="mt-2 text-white/70">
              {{ __('Legal_23') }}
            </p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_24') }}</h2>
            <p class="mt-2 text-white/70">
              {{ __('Legal_25') }}
            </p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_26') }}</h2>
            <p class="mt-2 text-white/70">
              {{ __('Legal_27') }}
            </p>
          </section>

          {{-- CONTACT CARD --}}
          <section class="rounded-2xl border border-white/10 bg-black/40 p-6">
            <h2 class="text-xl font-semibold text-[#2da9e0]">{{ __('Legal_28') }}</h2>
            <p class="mt-2 text-white/80">
              Sanbada Real Estate<br>
              {{ __('Legal_29') }}
              <a class="text-[#2da9e0] hover:underline" href="tel:+66653489444">+66 653 489 444</a>
            </p>
            <p class="mt-2 text-white/45 text-sm">
              {{ __('Legal_30') }} {{ now()->format('d.m.Y') }}
            </p>
          </section>

        </div>
      </div>

      {{-- BACK --}}
      <div class="mt-10">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center gap-2 text-[#2da9e0] hover:opacity-80 transition">
          <span aria-hidden="true">←</span>
          {{ __('Legal_31') }}
        </a>
      </div>

    </div>
  </main>

  {{-- FOOTER --}}
  <footer class="border-t border-white/10 bg-black/40">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 text-sm text-white/50 flex flex-col md:flex-row gap-2 justify-between">
      <div>© {{ date('Y') }} Sanbada Real Estate</div>
      <div>
        <a class="hover:text-white" href="{{ route('privacy', ['locale' => app()->getLocale()]) }}">{{ __('Legal_32') }}</a>
      </div>
    </div>
  </footer>

</body>
</html>
