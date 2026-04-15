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
        Schema::create('pdf_contents', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('page_number');
            $table->text('content');
            $table->timestamps();

            $table->index(['file_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_contents');
    }
};
