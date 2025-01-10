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
        Schema::create('testimony', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // Kolom untuk nama
            $table->string('image')->nullable(); // Kolom untuk gambar (opsional)
            $table->text('testimony');        // Kolom untuk testimoni
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimony');
    }
};
