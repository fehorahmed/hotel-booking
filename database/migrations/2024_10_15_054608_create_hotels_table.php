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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->foreignId('division_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('sub_district_id')->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('created_by');
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('division_id')->on('divisions')->references('id');
            $table->foreign('district_id')->on('districts')->references('id');
            $table->foreign('sub_district_id')->on('sub_districts')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
