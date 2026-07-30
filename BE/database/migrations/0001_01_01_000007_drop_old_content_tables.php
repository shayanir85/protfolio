<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('my_skills');
        Schema::dropIfExists('images');
        Schema::dropIfExists('paragraph');
    }

    public function down(): void
    {
        // Tables dropped intentionally — no recovery migration needed.
        // Recreate them manually if needed.
    }
};
