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
        Schema::create('land', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('lt'); // Luas Tanh
            $table->string('surat'); // Kamar Tidur
            $table->string('lmb')->nullable(); // Kamar Tidur Pembantu
            $table->string('harga'); // Kamar Mandi
            $table->string('lokasi')->nullable(); // Kamar Mandi Pembantu
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land');
    }
};
