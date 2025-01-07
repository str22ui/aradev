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
        Schema::create('perumahan_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perumahan_id'); // Foreign key ke tabel perumahan
            $table->string('image_path'); // Menyimpan path gambar
            $table->timestamps();

            // Relasi dengan tabel perumahan
            $table->foreign('perumahan_id')->references('id')->on('perumahan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perumahan_images');
    }
};
