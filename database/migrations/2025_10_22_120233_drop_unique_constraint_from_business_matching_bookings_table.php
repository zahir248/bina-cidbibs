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
            // Drop the unique constraint that was based on identity_number
            $table->dropUnique('unique_identity_per_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_matching_bookings', function (Blueprint $table) {
            // Re-add the unique constraint (if needed for rollback)
            $table->unique(['business_matching_id', 'identity_number'], 'unique_identity_per_session');
        });
    }
};
