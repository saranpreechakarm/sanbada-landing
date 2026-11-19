<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('purpose', 20)->nullable();
            $table->string('budget_range', 20)->nullable();
            $table->string('preferred_area', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', fn (Blueprint $table) => $table->dropColumn(['purpose', 'budget_range', 'preferred_area']));
    }
};
