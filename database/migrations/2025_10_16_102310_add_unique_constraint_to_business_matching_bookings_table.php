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
        Schema::table('business_matching_bookings', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate registrations
            // One person (identity_number) can only register once per business matching session
            $table->unique(['business_matching_id', 'identity_number'], 'unique_identity_per_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_matching_bookings', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique('unique_identity_per_session');
        });
    }
};
