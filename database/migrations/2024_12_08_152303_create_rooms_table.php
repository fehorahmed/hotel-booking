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
            $table->string('room_no');
            $table->string('description');
            $table->foreignId('hotel_id');
            $table->foreignId('room_category_id');
            $table->foreignId('price_for_govt')->default(0);
            $table->foreignId('price_for_non_govt')->default(0);

            $table->boolean('is_special')->default(0);
            $table->boolean('status')->default(1);

            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();

            $table->foreign('hotel_id')->on('hotels')->references('id');
            $table->foreign('room_category_id')->on('room_categories')->references('id');
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
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
