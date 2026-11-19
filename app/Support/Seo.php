<?php

namespace App\Support;

use App\Models\Project;
use Illuminate\Support\Str;

class Seo
{
    public function url(string $path = ''): string
    {
        return rtrim(config('seo.url'), '/').($path === '' ? '' : '/'.ltrim($path, '/'));
    }

    public function slug(Project $project): string
    {
        return Str::slug($project->title) ?: 'property';
    }

    public function projectPath(Project $project, ?string $locale = null): string
    {
        return '/'.($locale ?? app()->getLocale()).'/projects/'.$project->id.'/'.$this->slug($project);
    }

    public function canIndex(): bool
    {
        $host = parse_url(config('seo.url'), PHP_URL_HOST);
        return app()->environment('production') && config('seo.indexable')
            && parse_url(config('seo.url'), PHP_URL_SCHEME) === 'https'
            && $host && !filter_var($host, FILTER_VALIDATE_IP)
            && $host !== 'localhost' && request()->getHost() === $host;
    }

    public function text(?string $value, int $length = 165): string
    {
        return Str::limit(Str::squish(strip_tags($value ?? '')), $length, '…');
    }

    public function home(): array
    {
        $ru = app()->getLocale() === 'ru';
        return $this->page(
            $ru ? 'Недвижимость на Пхукете: квартиры и виллы | Sanbada' : 'Phuket Condos & Villas for Sale | Sanbada Real Estate',
            $ru ? 'Подберите квартиру или виллу на Пхукете с Sanbada. Проекты, цены, консультации и сопровождение покупки. Команда на Пхукете, поддержка на русском и английском.' : 'Explore condos and villas for sale in Phuket with Sanbada. Compare projects, locations and starting prices. Speak with our Phuket team in English or Russian.',
            '/'.app()->getLocale(),
            ['/en', '/ru'],
            business: true,
        );
    }

    public function listing(?string $category = null): array
    {
        $ru = app()->getLocale() === 'ru';
        $suffix = match ($category) { 'condo' => '/condominiums', 'villa' => '/villas', default => '/projects' };
        $title = match ($category) {
            'condo' => $ru ? 'Квартиры и кондоминиумы на Пхукете' : 'Condos for Sale in Phuket',
            'villa' => $ru ? 'Виллы на продажу на Пхукете' : 'Villas for Sale in Phuket',
            default => $ru ? 'Проекты недвижимости на Пхукете' : 'Property Projects in Phuket',
        };
        $description = $ru ? $title.'. Сравните расположение, фотографии, описание и цены. Обсудите актуальное наличие с командой Sanbada.' : $title.'. Compare locations, project photos, descriptions and starting prices. Ask the Sanbada team for current availability and viewing options.';
        return $this->page($title.' | Sanbada', $description, '/'.app()->getLocale().$suffix, ['/en'.$suffix, '/ru'.$suffix]);
    }

    public function project(Project $project): array
    {
        $locale = app()->getLocale();
        $title = $project->seo_title[$locale] ?? null;
        $description = $project->seo_description[$locale] ?? null;
        $prefix = $locale === 'ru' ? 'Недвижимость на Пхукете' : 'Phuket property';
        $description = $description ?: trim($project->title.'. '.($project->location ? $project->location.'. ' : '').$project->localized('price').'. '.$project->localized('description'));
        $seo = $this->page($title ?: $project->title.' | '.$prefix.' | Sanbada', $description,
            $this->projectPath($project), [$this->projectPath($project, 'en'), $this->projectPath($project, 'ru')]);
        if ($image = $project->images[0] ?? null) {
            // Images are local validated CMS upload paths, never arbitrary HTML.
            $seo['image'] = $this->url($project->imagePaths()[0]);
        }
        $seo['schema'][] = [
            '@type' => 'RealEstateListing', '@id' => $seo['canonical'].'#listing',
            'url' => $seo['canonical'], 'name' => $project->title,
            'description' => $this->text($project->localized('description'), 500),
            'image' => $seo['image'], 'inLanguage' => $locale,
            'dateModified' => $project->updated_at?->toAtomString(),
        ];
        return $seo;
    }

    public function page(string $title, string $description, string $path, array $alternates, bool $business = false): array
    {
        $canonical = $this->url($path);
        $seo = [
            'title' => $this->text($title, 120), 'description' => $this->text($description),
            'canonical' => $canonical, 'image' => $this->url(config('seo.image')),
            'alternates' => ['en' => $this->url($alternates[0]), 'ru' => $this->url($alternates[1]), 'x-default' => $this->url($alternates[1])],
            'schema' => [
                ['@type' => 'WebPage', '@id' => $canonical.'#webpage', 'url' => $canonical, 'name' => $title, 'inLanguage' => app()->getLocale(), 'isPartOf' => ['@id' => $this->url().'#website']],
                ['@type' => 'WebSite', '@id' => $this->url().'#website', 'url' => $this->url(), 'name' => config('seo.name'), 'inLanguage' => ['en', 'ru']],
            ],
        ];
        if ($business) {
            $seo['schema'][] = [
                '@type' => 'RealEstateAgent', '@id' => $this->url().'#agency',
                'name' => config('seo.name'), 'url' => $this->url(),
                'image' => $seo['image'], 'telephone' => config('contact.people.0.phone'), 'email' => config('seo.email'),
                'contactPoint' => array_map(fn ($person) => ['@type' => 'ContactPoint', 'name' => $person['name'], 'telephone' => $person['phone'], 'contactType' => 'sales'], config('contact.people')),
                'address' => config('seo.address'), 'sameAs' => config('seo.same_as'), 'areaServed' => 'Phuket, Thailand',
            ];
        }
        return $seo;
    }

    public function breadcrumbs(array $items): array
    {
        $elements = [];
        foreach ($items as $name => $path) {
            $elements[] = ['@type' => 'ListItem', 'position' => count($elements) + 1, 'name' => $name, 'item' => $this->url($path)];
        }
        return ['@type' => 'BreadcrumbList', 'itemListElement' => $elements];
    }
}
