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
        Schema::create('github_repos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');                
                $table->string('full_name');
                $table->string('html_url');
                $table->longText('description')->nullable();
                $table->string('ssh_url');
                $table->integer('stargazers_count');
                $table->integer('watchers_count');
                $table->integer('forks_count');
                $table->string('pushed_at');
                $table->boolean('show');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_repos');
    }
};
