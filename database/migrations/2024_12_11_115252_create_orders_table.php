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
            $table->foreignId('user_id');
            $table->dateTime('date');
            $table->date('from');
            $table->date('to');
            $table->enum('order_type',['GOVT','NONGOVT']);

            $table->float('discount',8,2)->default(0);
            $table->float('total',8,2)->default(0);

            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('orders');
    }
};
