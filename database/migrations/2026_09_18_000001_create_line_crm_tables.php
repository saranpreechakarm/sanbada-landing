<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('line_customers', function (Blueprint $table) {
            $table->id();
            $table->string('line_user_id', 64)->unique();
            $table->string('display_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('sales_owner', 100)->nullable();
            $table->string('status', 40)->default('new');
            $table->timestamp('first_contact_at');
            $table->timestamp('last_contact_at')->index();
            $table->timestamps();
        });
        Schema::create('line_webhook_events', function (Blueprint $table) {
            $table->string('event_id', 100)->primary();
            $table->timestamp('created_at');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_access_line_crm')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('line_webhook_events');
        Schema::dropIfExists('line_customers');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('can_access_line_crm'));
    }
};
