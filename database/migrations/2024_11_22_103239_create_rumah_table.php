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
        Schema::create('rumah', function (Blueprint $table) {
            $table->id();
            $table->string('no_kavling');
            $table->integer('luas_tanah'); // dalam m²
            $table->integer('luas_bangunan'); // dalam m²
            $table->string('posisi'); // contoh: hook, tengah, pojok
            $table->string('harga'); // format harga
            $table->foreignId('perumahan_id')->constrained('perumahan')->onDelete('cascade');
            $table->enum('status', ['Available', 'Dp', 'Sold'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah');
    }
};
