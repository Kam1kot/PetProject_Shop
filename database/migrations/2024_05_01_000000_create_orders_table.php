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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->integer('order_number');
            $table->string('status');
            $table->string('payment_status');
            $table->string('delivery_status');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('delivery_method');
            $table->string('payment_method');
            $table->string('delivery_city');
            $table->string('delivery_address');
            $table->string('delivery_postal_code');
            $table->text('comment')->nullable();
            $table->float('subtotal');
            $table->float('discount_amount');
            $table->float('delivery_amount');
            $table->float('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
