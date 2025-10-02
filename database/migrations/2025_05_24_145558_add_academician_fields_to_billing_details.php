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
        Schema::table('billing_details', function (Blueprint $table) {
            $table->string('student_id', 50)->nullable()->after('tax_number');
            $table->string('academic_institution')->nullable()->after('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->dropColumn('academic_institution');
        });
    }
}; 