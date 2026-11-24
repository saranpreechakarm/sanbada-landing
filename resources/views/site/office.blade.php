<section id="office" class="mp-office"><div class="mp-container mp-office-grid">
    <div class="mp-office-info"><h2>{{ $ru ? 'Свяжитесь с нами' : 'Contact us' }}</h2>
        <h3>{{ $ru ? 'Адрес' : 'Address' }}</h3><address>Phuket Office<br>27/18 Moo 2, Palai,<br>T. Chalong, A. Muang Phuket, Phuket</address>
        <h3>{{ $ru ? 'Телефон' : 'Phone' }}</h3>@include('landing.partials.contact-phones')
        <h3>Email</h3><a href="mailto:sanbadarus@gmail.com">sanbadarus@gmail.com</a>
        <h3>{{ $ru ? 'Социальные сети' : 'Social media' }}</h3>
        <div class="mp-social-links">
            @foreach([['telegram','Telegram','https://t.me/sanbadarus'],['facebook','Facebook','https://www.facebook.com/profile.php?id=61579230497512'],['instagram','Instagram','https://www.instagram.com/sanbadarealestate_rus/'],['whatsapp','WhatsApp',config('contact.whatsapp_url')]] as [$type,$label,$href])
                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $label }} — Sanbada">@include('site.social-icon', ['type' => $type])<span>{{ $label }}</span></a>
            @endforeach
        </div>
    </div>
    <div class="mp-office-map"><iframe title="Sanbada Real Estate — Phuket office map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4251.00403404192!2d98.35228497582136!3d7.841843606439243!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30502f3d037ab4cd%3A0x7ead3cd5b8f25c69!2sSanbada%20Co.%2CLTD!5e1!3m2!1sth!2sth!4v1769416714833!5m2!1sth!2sth" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe><a href="https://www.google.com/maps?cid=9128018908378455145" target="_blank" rel="noopener noreferrer">{{ $ru ? 'Открыть в Google Maps' : 'Open in Google Maps' }} @include('site.icon', ['name' => 'arrow-up-right'])</a></div>
</div></section>

