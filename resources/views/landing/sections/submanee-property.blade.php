    {{-- SUBMANEE PROPERTY --}}
    <section id="submanee-property" class="bg-[#f3f3f3]">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 py-12 lg:py-16">
        <div class="grid items-center gap-10 lg:grid-cols-[minmax(0,1fr)_420px] lg:gap-16">
          <div class="flex min-w-0 flex-col justify-center py-2 lg:min-h-[500px] lg:py-0">
            <img
              src="{{ asset('logo-submanee-property.webp') }}"
              alt="Submanee Property"
              width="900"
              height="262"
              class="h-auto w-full max-w-[300px] object-contain object-left"
              loading="lazy"
              decoding="async" />

            <div class="mt-8 text-[12px] uppercase tracking-[0.28em] text-[#8a8f98]">
              {{ __('submanee_property_label') }}
            </div>

            <h2 class="mt-3 text-[32px] font-bold uppercase tracking-widest text-[#2f343a] sm:text-[40px]">
              {{ __('submanee_property_title') }}
            </h2>

            <p class="mt-7 max-w-2xl text-[18px] leading-8 text-[#6b7280] sm:text-[20px]">
              {{ __('submanee_property_description') }}
            </p>

            <a
              href="https://www.facebook.com/profile.php?id=61578250777027"
              target="_blank"
              rel="noopener noreferrer"
              aria-label="{{ __('submanee_property_facebook_aria') }}"
              class="mt-9 inline-flex w-fit items-center gap-3 rounded-full transition hover:brightness-95 focus:outline-none focus:ring-4 focus:ring-[#1877f2]/20">
              <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#1877f2] text-white shadow-sm">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.51 1.5-3.9 3.79-3.9 1.1 0 2.25.2 2.25.2v2.47h-1.27c-1.25 0-1.64.78-1.64 1.57V12h2.79l-.45 2.89h-2.34v6.99A10 10 0 0 0 22 12Z" />
                </svg>
              </span>
              <span class="inline-flex min-h-14 items-center rounded-full bg-[#1877f2] px-6 py-3 text-[16px] font-medium text-white sm:px-8 sm:text-[18px]">
                {{ __('submanee_property_facebook') }}
              </span>
            </a>
          </div>

          <div class="flex items-center justify-center lg:justify-end">
            <img
              src="{{ asset('img/team.webp') }}"
              alt="Submanee Property Team"
              width="1108"
              height="1477"
              class="h-[500px] w-[px] max-w-full rounded-[6px] object-cover object-center"
              loading="lazy"
              decoding="async" />
          </div>
        </div>
      </div>
    </section>
