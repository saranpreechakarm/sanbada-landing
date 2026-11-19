<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\Seo;

class SeoController extends Controller
{
    public function robots(Seo $seo)
    {
        $content = "User-agent: *\n";
        if (!$seo->canIndex()) {
            $content .= "Disallow: /\n";
        } else {
            $content .= "Allow: /\nDisallow: /admin\nDisallow: /crm\nDisallow: /api/\nDisallow: /mockup-review/\n";
            $content .= 'Sitemap: '.$seo->url('/sitemap.xml')."\n";
        }
        return response($content)->header('Content-Type', 'text/plain; charset=UTF-8')->header('Cache-Control', 'no-store');
    }

    public function sitemap(Seo $seo)
    {
        $rows = [];
        foreach (['en', 'ru'] as $locale) {
            foreach (['', '/projects', '/condominiums', '/villas'] as $suffix) {
                $rows[] = ['url' => $seo->url('/'.$locale.$suffix), 'alternates' => ['en' => $seo->url('/en'.$suffix), 'ru' => $seo->url('/ru'.$suffix)], 'updated' => null];
            }
            foreach (Project::where('is_published', true)->orderBy('id')->cursor() as $project) {
                $rows[] = ['url' => $seo->url($seo->projectPath($project, $locale)), 'alternates' => ['en' => $seo->url($seo->projectPath($project, 'en')), 'ru' => $seo->url($seo->projectPath($project, 'ru'))], 'updated' => $project->updated_at?->toAtomString()];
            }
        }
        return response()->view('seo.sitemap', compact('rows'))->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
