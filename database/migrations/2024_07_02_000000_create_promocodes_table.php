<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('type');
            $table->float('value');
            $table->float('min_order_amount');
            $table->unsignedBigInteger('usage_limit');
            $table->unsignedBigInteger('usage_count');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
