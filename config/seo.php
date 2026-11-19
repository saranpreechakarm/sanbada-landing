<?php

return [
    'url' => rtrim(env('SEO_SITE_URL', 'https://realestate.sanbadathai.com'), '/'),
    // Also requires production environment and a matching request host.
    'indexable' => (bool) env('SEO_INDEXABLE', true),
    'name' => 'Sanbada Real Estate',
    'image' => 'assets/optimized/investment/1.webp',
    'email' => 'sanbadarus@gmail.com',
    'address' => [
        '@type' => 'PostalAddress', 'streetAddress' => '27/18 Moo 2, Palai, T. Chalong',
        'addressLocality' => 'Muang Phuket', 'addressRegion' => 'Phuket', 'addressCountry' => 'TH',
    ],
    'same_as' => [
        'https://www.facebook.com/profile.php?id=61579230497512',
        'https://www.instagram.com/sanbadarealestate_rus/',
        'https://t.me/sanbadarus',
    ],
];
