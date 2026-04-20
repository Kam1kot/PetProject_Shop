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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label')->nullable();;
            $table->string('recipient_name')->nullable();;
            $table->string('recipient_phone')->nullable();;
            $table->string('country')->nullable();;
            $table->string('city')->nullable();;
            $table->string('street')->nullable();;
            $table->string('house')->nullable();;
            $table->string('apartment')->nullable();;
            $table->string('postal_code')->nullable();;
            $table->text('comment')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
