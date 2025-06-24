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
        Schema::table('orders', function (Blueprint $table) {
            // Add payment-related columns
            $table->string('payment_id')->nullable()->after('cart_items');
            $table->string('payment_method')->nullable()->after('status');
            $table->string('payment_country')->nullable()->after('payment_method');
            $table->decimal('processing_fee', 10, 2)->nullable()->after('payment_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_id',
                'payment_method',
                'payment_country',
                'processing_fee'
            ]);
        });
    }
}; 