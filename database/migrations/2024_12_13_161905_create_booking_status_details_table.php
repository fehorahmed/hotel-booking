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
        Schema::create('booking_status_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id');
            $table->foreignId('user_id');
            $table->foreignId('order_id')->nullable();
            $table->foreignId('order_detail_id')->nullable();
            $table->dateTime('date');
            $table->enum('status',['RESERVED','BOOKED','AVAILABLE'])->comment('RESERVED,BOOKED,AVAILABLE');

            $table->foreign('order_id')->on('orders')->references('id');
            $table->foreign('order_detail_id')->on('order_details')->references('id');
            $table->foreign('room_id')->on('rooms')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_status_details');
    }
};
