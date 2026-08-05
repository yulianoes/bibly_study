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
        Schema::create('query_logs', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->string('theme')->nullable();
            $table->string('intent')->nullable();
            $table->string('ai_provider')->nullable();
            $table->boolean('success')->default(true);
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamps();

            $table->index(['ai_provider']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('query_logs');
    }
};
