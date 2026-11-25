  {{-- NAVBAR --}}
  @php
  $locale = app()->getLocale(); // ru | en
  $ru = $locale === 'ru';
  $onHome = request()->routeIs('home');
  $sectionBase = $onHome ? '' : route('home', $locale);
  $hasVideos = isset($videos) ? $videos->isNotEmpty() : \App\Models\Video::where('is_published', true)->exists();
  $hasNewProjects = isset($newProjects) ? $newProjects->isNotEmpty() : \App\Models\Project::where('is_published', true)->where('is_new', true)->exists();
  $languageUrl = fn ($language) => isset($project) && !$onHome
    ? app(\App\Support\Seo::class)->projectPath($project, $language)
    : ($onHome ? route('home', $language) : route(request()->route()->getName(), ['locale' => $language, ...request()->only('page')], false));
  $ruUrl = $languageUrl('ru');
  $enUrl = $languageUrl('en');
  @endphp

  <header class="site-header sticky top-0 z-40 bg-[#2f343a] border-b border-black/30"
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
      <nav class="hidden xl:flex items-center gap-10 text-[12px] tracking-[.20em] uppercase text-white/80">
        <a href="{{ $sectionBase }}#projects" class="scroll-mt-20 hover:text-white transition">{{ (app()->getLocale() === 'ru' ? 'Проекты' : 'Properties') }}</a>
        @if($hasVideos)<a href="{{ $sectionBase }}#videos" class="scroll-mt-20 hover:text-white transition">{{ app()->getLocale() === 'ru' ? 'Видео' : 'Videos' }}</a>@endif
        <a href="{{ $sectionBase }}#about" class="scroll-mt-20 hover:text-white transition">{{ (app()->getLocale() === 'ru' ? 'О нас' : 'About us') }}</a>
        <a href="{{ $sectionBase }}#invest2" class="scroll-mt-20 hover:text-white transition">{{ (app()->getLocale() === 'ru' ? 'Инвестиции' : 'Investments') }}</a>
        <a href="{{ $sectionBase }}#office" class="scroll-mt-20 hover:text-white transition">{{ (app()->getLocale() === 'ru' ? 'Контакты' : 'Contacts') }}</a>
      </nav>

      {{-- Right actions: language switch + mobile button --}}
      <div class="flex items-center gap-3">

        {{-- Language dropdown (desktop) --}}
        <div class="hidden xl:block relative"
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
              {{ $locale === 'ru' ? 'RU' : 'EN' }}
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
              <span class="text-lg">RU</span>
              <div class="leading-tight">
                <div class="text-slate-800 font-medium">Русский</div>
              </div>
            </a>

            <a href="{{ $enUrl }}"
              class="flex items-center gap-3 px-4 py-3 text-[14px]
              hover:bg-slate-50 {{ $locale==='en' ? 'bg-slate-50' : '' }}">
              <span class="text-lg">EN</span>
              <div class="leading-tight">
                <div class="text-slate-800 font-medium">English</div>
              </div>
            </a>
          </div>
        </div>

{{-- Mobile button --}}
        <button
          class="xl:hidden inline-flex items-center justify-center h-10 w-10 rounded-lg border border-white/15 text-white/80 hover:text-white hover:border-white/25"
          @click="$dispatch('toggle-mobile-menu')"
          aria-label="{{ $ru ? 'Меню' : 'Menu' }}" :aria-expanded="mobileOpen.toString()" aria-controls="site-mobile-menu">
          @include('site-c.icon', ['name' => 'menu'])
        </button>

      </div>
    </div>

    {{-- MOBILE DRAWER --}}
    <div class="xl:hidden">
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
        id="site-mobile-menu" class="mobile-menu-panel fixed top-0 right-0 z-50 h-full w-[86%] max-w-sm
             bg-[#2b3036] border-l border-white/10 shadow-2xl">
        {{-- Header in drawer --}}
        <div class="mobile-menu-heading h-16 px-6 flex items-center justify-between border-b border-white/10">
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
                  {{ $locale === 'ru' ? 'RU' : 'EN' }}
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
                  <span class="text-lg">RU</span>
                  <div class="leading-tight">
                    <div class="text-slate-800 font-medium">Русский</div>
                  </div>
                </a>

                <a href="{{ $enUrl }}"
                  class="flex items-center gap-3 px-4 py-3 text-[14px]
                  hover:bg-slate-50 {{ $locale==='en' ? 'bg-slate-50' : '' }}">
                  <span class="text-lg">EN</span>
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
            @include('site-c.icon', ['name' => 'x'])
          </button>
        </div>



        {{-- Links --}}
        <nav class="px-6 py-6 text-[12px] uppercase tracking-[.18em]">

          <a href="{{ $sectionBase }}#about"
            @click="mobileOpen=false"
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ (app()->getLocale() === 'ru' ? 'О нас' : 'About us') }}
          </a>

          <a href="{{ $sectionBase }}#invest2"
            @click="mobileOpen=false"
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ (app()->getLocale() === 'ru' ? 'Инвестиции' : 'Investments') }}
          </a>

          <a href="{{ $sectionBase }}#projects"
            @click="mobileOpen=false"
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ (app()->getLocale() === 'ru' ? 'Проекты' : 'Properties') }}
          </a>

          @if($hasNewProjects)
          <a href="{{ $sectionBase }}#new-projects" @click="mobileOpen=false" class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">{{ __('content.new_projects') }}</a>
          @endif
          @if($hasVideos)
          <a href="{{ $sectionBase }}#videos" @click="mobileOpen=false" class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">{{ app()->getLocale() === 'ru' ? 'Видео' : 'Videos' }}</a>
          @endif
          <a href="{{ $sectionBase }}#office"
            @click="mobileOpen=false"
            class="block py-4 border-b border-white/10 text-white/85 hover:text-white transition">
            {{ (app()->getLocale() === 'ru' ? 'Контакты' : 'Contacts') }}
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
