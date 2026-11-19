<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', fn (Blueprint $table) => $table->string('aspect_ratio', 10)->default('16:9'));
        DB::table('videos')->where('url', 'like', '%youtube.com/shorts/%')->update(['aspect_ratio' => '9:16']);
    }

    public function down(): void
    {
        Schema::table('videos', fn (Blueprint $table) => $table->dropColumn('aspect_ratio'));
    }
};
