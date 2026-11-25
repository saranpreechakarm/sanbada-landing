<?php

namespace App\Support;

use App\Models\Project;

class ProjectImages
{
    private ?array $manifest = null;

    public function slides(Project $project): array
    {
        if ($this->manifest === null) {
            $path = public_path('mockup-c-assets/image-manifest.json');
            $this->manifest = is_file($path) ? json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR) : [];
        }

        return array_map(fn (string $path) => [
            'small' => asset($this->manifest[$path]['small'] ?? $path),
            'large' => asset($this->manifest[$path]['large'] ?? $path),
        ], $project->imagePaths());
    }
}
