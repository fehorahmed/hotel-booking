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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('room_id');

            $table->foreignId('price_for_govt')->default(0);
            $table->foreignId('price_for_non_govt')->default(0);

            $table->float('amount',8,2)->default(0);
            $table->boolean('status')->default(1);
            $table->foreign('order_id')->on('orders')->references('id');
            $table->foreign('room_id')->on('rooms')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
