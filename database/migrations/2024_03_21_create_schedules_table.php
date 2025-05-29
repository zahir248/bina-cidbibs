<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('session')->nullable(); // For storing session numbers like "SESSION 1", "SESSION 2"
            $table->string('event_type'); // For storing event type like "facility_management", "modular_asia"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}; 