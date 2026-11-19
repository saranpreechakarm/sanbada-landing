<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table->boolean('can_manage_content')->default(false));
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_key')->nullable()->unique();
            $table->string('title');
            $table->string('category', 20)->index();
            $table->string('location')->nullable();
            $table->json('badge');
            $table->json('price');
            $table->json('description');
            $table->json('images');
            $table->string('pdf_path', 500)->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('content_admin_setup', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
        });
        \Illuminate\Support\Facades\DB::table('content_admin_setup')->insert(['id' => 1]);
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->json('title');
            $table->json('description');
            $table->string('url', 500);
            $table->boolean('is_published')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('content_admin_setup');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('can_manage_content'));
    }
};
