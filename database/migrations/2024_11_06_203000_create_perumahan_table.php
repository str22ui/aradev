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
        Schema::create('perumahan', function (Blueprint $table) {
            $table->id();
            $table->string('perumahan');
            $table->string('lokasi')->nullable();
            $table->integer('luas')->nullable(); // Luas dalam satuan meter persegi misalnya
            $table->integer('unit')->nullable();
            $table->string('kota')->nullable();
            $table->decimal('harga', 15, 2); // Harga dengan presisi 15 digit, 2 digit desimal
            $table->string('brosur')->nullable(); // Bisa menyimpan path file brosur
            $table->string('pricelist')->nullable(); // Path untuk file pricelist
            $table->string('img')->nullable(); // Path untuk gambar
            $table->enum('status', ['available', 'sold_out'])->default('available');
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perumahan');
    }
};
