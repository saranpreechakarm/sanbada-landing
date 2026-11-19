<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Video;

class LandingController extends Controller
{
    public function __invoke()
    {
        $projects = Project::where('is_published', true)->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('id')->get();
        return view('landing', [
            'projects' => $projects,
            'newProjects' => $projects->where('is_new', true),
            'videos' => Video::with('project')->where('is_published', true)->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }
}
