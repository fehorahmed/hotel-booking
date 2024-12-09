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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('hotel_id');
            $table->foreignId('room_category_id');

            $table->boolean('is_special')->default(0);
            $table->boolean('status')->default(1);

            $table->foreign('hotel_id')->on('hotels')->references('id');
            $table->foreign('room_category_id')->on('room_categories')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
