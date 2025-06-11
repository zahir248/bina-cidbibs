<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Category
            $table->string('category')->nullable();
            
            // Non-academic fields
            $table->string('mobile_number')->nullable();
            
            // Academic fields
            $table->string('student_id')->nullable();
            $table->string('academic_institution')->nullable();
            
            // Organization fields
            $table->string('job_title')->nullable();
            $table->string('organization')->nullable();
            $table->string('green_card')->nullable();
            $table->string('impact_number')->nullable();
            
            // Common fields
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->text('about_me')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            
            // Social media fields
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}; 