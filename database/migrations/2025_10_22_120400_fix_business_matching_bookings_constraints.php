<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to handle the constraint issue
        DB::statement('ALTER TABLE business_matching_bookings DROP INDEX unique_identity_per_session');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back identity_number column
        Schema::table('business_matching_bookings', function (Blueprint $table) {
            $table->string('identity_number')->nullable()->after('company_name');
        });
        
        // Re-add the unique constraint
        Schema::table('business_matching_bookings', function (Blueprint $table) {
            $table->unique(['business_matching_id', 'identity_number'], 'unique_identity_per_session');
        });
    }
};
