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
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp');
            $table->string('domisili');
            $table->enum('permintaan', ['Jual', 'Menyewakan', 'Beli', 'Sewa']);
            $table->enum('jenis', ['Rumah', 'Tanah', 'Apartemen']);
            $table->enum('lokasi', ['Jakarta', 'Tangerang', 'Depok', 'Bogor', 'Bekasi', 'Luar Jabodetabek']);
            $table->string('spesifik_lokasi')->nullable();
            $table->string('harga_budget');
            $table->text('keterangan')->nullable();
            $table->enum('approval', ['Tampilkan', 'Sembunyikan'])->default('Sembunyikan');
            $table->enum('status', ['Available', 'Closed', 'Removed'])->default('Available');
            $table->timestamps();   

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist');
    }
};
