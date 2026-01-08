<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('leads', function (Blueprint $table) {
    $table->id();

    $table->string('whatsapp_country', 10)->default('+66');
    $table->string('whatsapp_phone', 30);
    $table->string('email')->nullable();
    $table->string('name')->nullable();

    $table->boolean('consent')->default(false);

    $table->string('source')->nullable(); // website/facebook/etc.
    $table->string('status')->default('new');

    $table->timestamps();
});
