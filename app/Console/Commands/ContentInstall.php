<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContentInstall extends Command
{
    protected $signature = 'content:install';
    protected $description = 'Install the content tables and import the original projects without overwriting edits';

    public function handle(): int
    {
        // The pre-existing leads migration has top-level schema changes. Never run it as part of this installer.
        $exit = $this->call('migrate', ['--path' => [
            'database/migrations/2026_11_18_000001_create_content_admin_tables.php',
            'database/migrations/2026_11_18_000002_add_video_aspect_ratio.php',
            'database/migrations/2026_11_18_000003_add_lead_management_and_video_covers.php',
        ], '--force' => true]);
        if ($exit !== 0) {
            return self::FAILURE;
        }
        $translations = [];
        foreach (['en', 'ru'] as $locale) {
            $translations[$locale] = json_decode(file_get_contents(resource_path('lang/'.$locale.'.json')), true, 512, JSON_THROW_ON_ERROR);
        }
        $count = 0;
        DB::transaction(function () use ($translations, &$count) {
            foreach (require database_path('data/legacy-projects.php') as $order => $legacy) {
                $localized = fn ($key) => ['en' => $translations['en'][$legacy[$key]] ?? '', 'ru' => $translations['ru'][$legacy[$key]] ?? ''];
                $project = Project::withTrashed()->firstOrCreate(['legacy_key' => Str::slug($legacy['title'])], [
                    'title' => $legacy['title'], 'category' => str_contains(strtoupper($legacy['title']), 'VILLA') ? 'villa' : 'condo',
                    'badge' => $localized('badge_key'), 'price' => $localized('price_key'), 'description' => $localized('desc_key'),
                    'images' => array_map(fn ($image) => 'assets/projects/'.$image, $legacy['images']),
                    'pdf_path' => $legacy['pdf'], 'sort_order' => $order * 10, 'is_published' => true,
                ]);
                $count += (int) $project->wasRecentlyCreated;
            }
        });
        $this->info('Imported '.$count.' original projects. Existing edits preserved.');
        $this->info('Run php artisan content:setup-link to create the first administrator.');
        return self::SUCCESS;
    }
}
