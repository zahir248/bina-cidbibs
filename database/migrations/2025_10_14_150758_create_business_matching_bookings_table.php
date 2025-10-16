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
        Schema::create('business_matching_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_matching_id')->constrained()->onDelete('cascade');
            $table->foreignId('panel_id')->constrained('business_matching_panels')->onDelete('cascade');
            $table->foreignId('time_slot_id')->constrained('business_matching_time_slots')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('participant_name');
            $table->string('participant_email');
            $table->string('participant_phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('business_type')->nullable();
            $table->json('interests')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_matching_bookings');
    }
};
