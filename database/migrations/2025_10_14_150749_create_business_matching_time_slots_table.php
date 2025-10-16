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
        Schema::create('business_matching_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_matching_id')->constrained()->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('group', ['A', 'B']); // Group A or Group B
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_matching_time_slots');
    }
};
