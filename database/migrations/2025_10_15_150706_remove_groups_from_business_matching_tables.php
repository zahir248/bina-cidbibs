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
        Schema::table('business_matching_panels', function (Blueprint $table) {
            $table->dropColumn('group');
        });

        Schema::table('business_matching_time_slots', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_matching_panels', function (Blueprint $table) {
            $table->string('group')->after('description');
        });

        Schema::table('business_matching_time_slots', function (Blueprint $table) {
            $table->string('group')->after('end_time');
        });
    }
};
