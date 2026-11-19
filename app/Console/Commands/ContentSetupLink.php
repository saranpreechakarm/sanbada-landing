<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class ContentSetupLink extends Command
{
    protected $signature = 'content:setup-link {--base-url= : Override APP_URL for a local installation}';
    protected $description = 'Generate a private, 30-minute link for the first website administrator';

    public function handle(): int
    {
        if (User::where('can_manage_content', true)->exists()) {
            $this->error('An administrator already exists. Use /admin/login.');
            return self::FAILURE;
        }
        $base = rtrim($this->option('base-url') ?: config('app.url'), '/');
        if (!filter_var($base, FILTER_VALIDATE_URL) || !in_array(parse_url($base, PHP_URL_SCHEME), ['http', 'https'], true)) {
            $this->error('Set APP_URL or --base-url to the website URL.');
            return self::FAILURE;
        }
        URL::forceRootUrl($base);
        URL::forceScheme(parse_url($base, PHP_URL_SCHEME));
        $this->line(URL::temporarySignedRoute('admin.setup', now()->addMinutes(30)));
        $this->info('Private setup link: expires in 30 minutes and closes after the first administrator is created.');
        return self::SUCCESS;
    }
}
