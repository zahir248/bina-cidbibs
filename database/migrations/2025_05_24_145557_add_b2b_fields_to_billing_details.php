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
            $table->string('company_name')->nullable()->after('email');
            $table->string('business_registration_number')->nullable()->after('company_name');
            $table->string('tax_number')->nullable()->after('business_registration_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'business_registration_number',
                'tax_number'
            ]);
        });
    }
}; 