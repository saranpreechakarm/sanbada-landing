<div class="site-dialog-root lead-dialog-root" x-data="leadDialog(@js(['hasErrors'=>$errors->any() && old('lead_context') !== 'shortlist', 'project'=>old('project'), 'projectId'=>old('project_id'), 'pdf'=>old('pdf')]))"
    x-show="open" x-cloak @open-lead.window="show($event.detail || {})" @close-lead.window="close()"
    @keydown.escape.window="close()" @keydown.window="trap($event)" :aria-hidden="!open">
    <div class="site-dialog-overlay" @click="close()"></div>
    <section class="lead-dialog" role="dialog" aria-modal="true" aria-labelledby="lead-dialog-title">
        <header class="site-dialog-header"><strong>Sanbada Real Estate</strong><button type="button" @click="close()" aria-label="{{ __('content.close') }}">×</button></header>
        <div class="lead-dialog-body">
            <div class="lead-dialog-form">
                <h2 id="lead-dialog-title">{{ __('content.request_details') }}</h2>
                <p class="lead-dialog-project" x-show="project" x-text="project"></p>
                <p class="lead-copy-note" x-show="pdf" x-cloak>{{ app()->getLocale() === 'ru' ? 'Заполните форму, чтобы скачать PDF-брошюру выбранного проекта.' : 'Complete the form to download the PDF brochure for this project.' }}</p>
                @if($errors->any())<div class="lead-form-errors" role="alert">@foreach($errors->all() as $message)<p>{{ $message }}</p>@endforeach</div>@endif
                <form method="post" action="{{ route('lead.store', app()->getLocale()) }}" @submit="submitting = true">
                    @csrf
                    <input type="hidden" name="project_id" :value="projectId || ''">
                    <input type="hidden" name="project" :value="project || ''">
                    <input type="hidden" name="pdf" :value="pdf || ''">
                    @foreach(['utm_source','utm_medium','utm_campaign','utm_content','utm_term'] as $field)<input type="hidden" name="{{ $field }}" value="{{ old($field, is_string(request()->query($field)) ? mb_substr(request()->query($field), 0, 255) : '') }}">@endforeach
                    <div class="lead-honeypot" aria-hidden="true"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></div>
                    <label for="lead-phone">{{ __('modal_9') }}</label>
                    <div class="lead-phone-row"><select name="whatsapp_country" aria-label="{{ __('content.country_code') }}">@foreach(['+66','+7','+48','+1'] as $country)<option value="{{ $country }}" @selected(old('whatsapp_country', '+66') === $country)>{{ $country }}</option>@endforeach</select><input id="lead-phone" x-ref="phone" type="tel" name="whatsapp_phone" value="{{ old('whatsapp_phone') }}" required inputmode="tel" maxlength="30" autocomplete="tel-national" placeholder="{{ __('modal_16') }}"></div>
                    <label for="lead-email">{{ __('modal_10') }}</label><input id="lead-email" type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" placeholder="mail@example.com">
                    <label for="lead-name">{{ __('modal_11') }}</label><input id="lead-name" name="name" value="{{ old('name') }}" maxlength="255" autocomplete="name" placeholder="{{ __('modal_17') }}">
                    <label class="lead-consent"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>{{ __('modal_13') }} <a href="{{ route('privacy', app()->getLocale()) }}" target="_blank" rel="noopener">{{ __('modal_14') }}</a></span></label>
                    <button type="submit" class="lead-submit btn-lux btn-sweep is-in-view" :disabled="submitting" x-text="pdf ? @js(app()->getLocale() === 'ru' ? 'Получить PDF проекта' : 'Get project PDF') : @js(__('modal_12'))">{{ __('modal_12') }}</button>
                    <p class="lead-form-footnote">{{ __('modal_15') }}</p>
                </form>
            </div>
            <div class="lead-dialog-copy"><span class="lead-offer-label">● {{ __('modal_1') }}</span><h3>{{ __('modal_2') }}</h3><strong>{{ __('modal_3') }}</strong><p class="lead-copy-note">{{ __('modal_4') }} <strong x-text="project || ''"></strong></p><ul><li>{{ __('modal_5') }}</li><li>{{ __('modal_6') }}</li><li>{{ __('modal_7') }}</li></ul><p class="lead-copy-note">{{ __('modal_8') }}</p></div>
        </div>
    </section>
</div>
