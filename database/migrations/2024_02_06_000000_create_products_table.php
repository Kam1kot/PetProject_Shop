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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();;
            $table->text('description');
            $table->float('price');
            $table->float('old_price')->nullable();
            $table->integer('quantity');
            $table->string('status');
            $table->boolean('is_new');
            $table->boolean('is_hit');
            $table->unsignedBigInteger('reviews_count')->default(0);
            $table->float('rating_avg')->default(0);
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
