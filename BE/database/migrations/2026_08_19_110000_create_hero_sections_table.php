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
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            
            // Titles & Text
            $table->string('badge_text')->nullable();
            $table->string('greeting')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            
            // Job Availability Status
            $table->boolean('show_availability')->default(true);
            $table->string('availability_status')->default('available'); // available, open_to_work, busy, unavailable
            $table->boolean('availability_pulse')->default(true);
            
            // Typewriter Effect Builder
            $table->boolean('enable_typewriter')->default(true);
            $table->string('typewriter_prefix')->nullable();
            $table->json('typewriter_strings')->nullable();
            $table->integer('typewriter_speed')->default(80);
            $table->integer('typewriter_delete_speed')->default(40);
            $table->integer('typewriter_delay')->default(2000);
            
            // Action Buttons Builder
            $table->json('buttons')->nullable();
            
            // Stats Row Builder
            $table->json('stats')->nullable();
            
            // Scroll Indicator & Display Settings
            $table->string('scroll_indicator_text')->nullable();
            $table->boolean('show_scroll_indicator')->default(true);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
