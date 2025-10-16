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
            $table->dropForeign(['panel_id']);
            $table->dropColumn('panel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_matching_bookings', function (Blueprint $table) {
            $table->foreignId('panel_id')->constrained('business_matching_panels')->onDelete('cascade');
        });
    }
};
