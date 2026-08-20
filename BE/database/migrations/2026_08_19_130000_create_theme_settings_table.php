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
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color')->default('#667eea');
            $table->string('secondary_color')->default('#764ba2');
            $table->string('accent_color')->default('#06b6d4');
            $table->string('gradient_start')->default('#667eea');
            $table->string('gradient_end')->default('#764ba2');
            $table->string('gradient_angle')->default('135deg');
            $table->string('dark_primary_color')->nullable()->default('#818cf8');
            $table->string('dark_secondary_color')->nullable()->default('#a78bfa');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
