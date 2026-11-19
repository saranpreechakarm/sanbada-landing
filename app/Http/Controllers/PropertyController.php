<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\Seo;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request, Seo $seo)
    {
        $category = match ($request->route()->getName()) { 'properties.condos' => 'condo', 'properties.villas' => 'villa', default => null };
        $projects = Project::where('is_published', true)->when($category, fn ($q) => $q->where('category', $category))->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('id')->paginate(12);
        $metadata = $seo->listing($category);
        $metadata['schema'][] = $seo->breadcrumbs([app()->getLocale() === 'ru' ? 'Главная' : 'Home' => '/'.app()->getLocale(), explode(' | ', $metadata['title'])[0] => request()->path()]);
        if ($projects->currentPage() > 1) {
            $metadata['canonical'] .= '?page='.$projects->currentPage();
            $metadata['title'] .= app()->getLocale() === 'ru' ? ' — Страница '.$projects->currentPage() : ' — Page '.$projects->currentPage();
            foreach ($metadata['alternates'] as &$alternate) $alternate .= '?page='.$projects->currentPage();
            unset($alternate);
            $metadata['schema'][0]['url'] = $metadata['canonical'];
            $metadata['schema'][0]['@id'] = $metadata['canonical'].'#webpage';
        }
        abort_if($projects->currentPage() > $projects->lastPage(), 404);
        $metadata['schema'][] = ['@type' => 'ItemList', 'itemListElement' => $projects->map(fn ($project, $index) => ['@type' => 'ListItem', 'position' => $projects->firstItem() + $index, 'url' => $seo->url($seo->projectPath($project)), 'name' => $project->title])->all()];
        return view('properties.index', ['projects' => $projects, 'category' => $category, 'seo' => $metadata, 'locale' => app()->getLocale(), 'ru' => app()->getLocale() === 'ru']);
    }

    public function show(string $locale, Project $project, string $slug, Seo $seo)
    {
        abort_unless($project->is_published, 404);
        if ($slug !== $seo->slug($project)) {
            return redirect($seo->projectPath($project, $locale), 301);
        }
        $metadata = $seo->project($project);
        $metadata['schema'][] = $seo->breadcrumbs([app()->getLocale() === 'ru' ? 'Главная' : 'Home' => '/'.$locale, app()->getLocale() === 'ru' ? 'Проекты' : 'Projects' => '/'.$locale.'/projects', $project->title => $seo->projectPath($project)]);
        return view('properties.show', ['project' => $project, 'seo' => $metadata, 'locale' => $locale, 'ru' => $locale === 'ru']);
    }
}
