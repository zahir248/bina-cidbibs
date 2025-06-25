<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'bina' or 'fm'
            $table->string('episode_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('youtube_url')->nullable();
            $table->json('panelists')->nullable(); // Store panelist info as JSON
            $table->boolean('is_live_streaming')->default(false);
            $table->string('live_streaming_event')->nullable();
            $table->boolean('is_coming_soon')->default(false);
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('podcasts');
    }
}; 