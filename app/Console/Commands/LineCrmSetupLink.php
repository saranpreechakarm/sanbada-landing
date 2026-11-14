<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class LineCrmSetupLink extends Command
{
    protected $signature = 'crm:setup-link';
    protected $description = 'Generate a 30-minute link for the owner to create the first CRM login';

    public function handle(): int
    {
        if (User::where('can_access_line_crm', true)->exists()) {
            $this->error('A CRM staff account already exists. Initial setup is closed.');
            return self::FAILURE;
        }
        URL::forceRootUrl('https://realestate.sanbadathai.com');
        URL::forceScheme('https');
        $this->line(URL::temporarySignedRoute('crm.setup', now()->addMinutes(30)));
        $this->info('Private owner setup link. Expires in 30 minutes; closes after the first CRM account is created.');
        return self::SUCCESS;
    }
}
