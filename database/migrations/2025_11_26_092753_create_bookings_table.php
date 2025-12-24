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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('user_id');     // client
            $table->unsignedBigInteger('washer_id');   // washer
            $table->unsignedBigInteger('region_id')->nullable(); // region

            // Booking details
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->enum('type', ['basic', 'premium', 'intérieur', 'extérieur']);
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'done', 'cancelled'])
                ->default('pending');
            $table->string('note')->nullable();
            $table->text('comment')->nullable();
            $table->string('payment_method')->nullable(); // payment method

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('user_accounts')->cascadeOnDelete();
            $table->foreign('washer_id')->references('id')->on('user_accounts')->cascadeOnDelete();
            $table->foreign('region_id')->references('id')->on('regions')->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
