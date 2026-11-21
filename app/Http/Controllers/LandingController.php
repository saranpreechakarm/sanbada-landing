<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Video;

// Homepage C reads the existing admin-managed projects and videos. No database writes.
class LandingController extends Controller
{
    public function __invoke()
    {
        $projects = Project::where('is_published', true)->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('id')->get();
        $videos = Video::with('project')->where('is_published', true)->orderBy('sort_order')->get();
        $manifestPath = public_path('mockup-c-assets/image-manifest.json');
        $manifest = is_file($manifestPath) ? json_decode(file_get_contents($manifestPath), true, 512, JSON_THROW_ON_ERROR) : [];
        $previewImage = static fn (string $path) => [
            'small' => asset($manifest[$path]['small'] ?? $path),
            'large' => asset($manifest[$path]['large'] ?? $path),
        ];
        $previewSlides = static fn ($project) => array_map($previewImage, $project->imagePaths());

        return view('site-c.landing', [
            'projects' => $projects, 'newProjects' => $projects->where('is_new', true), 'videos' => $videos,
            'previewImage' => $previewImage, 'previewSlides' => $previewSlides,
        ]);
    }
}
