<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Some installations have the legacy leads table without a migration record.
        // This targeted migration also supports an empty test database without rerunning that legacy file.
        if (!Schema::hasTable('leads')) {
            Schema::create('leads', function (Blueprint $table) {
                $table->id();
                $table->string('whatsapp_country', 10)->default('+66');
                $table->string('whatsapp_phone', 30);
                $table->string('email')->nullable();
                $table->string('name')->nullable();
                $table->boolean('consent')->default(false);
                $table->string('source')->nullable();
                $table->string('status')->default('new');
                $table->timestamps();
            });
        }
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('project_name')->nullable();
            $table->string('project_category', 20)->nullable();
            $table->string('locale', 5)->nullable();
            $table->string('phone_normalized', 30)->nullable()->index();
            foreach (['source', 'medium', 'campaign', 'content', 'term'] as $part) {
                $table->string('utm_'.$part)->nullable();
            }
            $table->string('sales_owner', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('next_follow_up_at')->nullable()->index();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->index(['created_at', 'status']);
        });
        DB::table('leads')->orderBy('id')->chunkById(200, function ($leads) {
            foreach ($leads as $lead) {
                DB::table('leads')->where('id', $lead->id)->update([
                    'phone_normalized' => \App\Models\Lead::normalizePhone($lead->whatsapp_country, $lead->whatsapp_phone),
                ]);
            }
        });
        Schema::table('videos', fn (Blueprint $table) => $table->string('cover_path', 500)->nullable());
    }

    public function down(): void
    {
        Schema::table('videos', fn (Blueprint $table) => $table->dropColumn('cover_path'));
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropIndex(['created_at', 'status']);
            $table->dropColumn(['project_id', 'project_name', 'project_category', 'locale', 'phone_normalized',
                'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term',
                'sales_owner', 'notes', 'next_follow_up_at', 'contacted_at', 'closed_at']);
        });
    }
};
