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
        Schema::create('secondary', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['Dijual', 'Disewakan']); // Dijual/Disewakan
            $table->string('judul');
            $table->integer('lt'); // Luas Tanah
            $table->integer('lb'); // Luas Bangunan
            $table->integer('kt'); // Kamar Tidur
            $table->integer('ktp')->nullable(); // Kamar Tidur Pembantu
            $table->integer('km'); // Kamar Mandi
            $table->integer('kmp')->nullable(); // Kamar Mandi Pembantu
            $table->integer('carport')->nullable();
            $table->integer('garasi')->nullable();
            $table->integer('listrik')->nullable();
            $table->string('air')->nullable();
            $table->string('surat')->nullable();
            $table->string('lmb')->nullable(); // LMB
            $table->enum('posisi', ['Hook', 'Badan'])->nullable();
            $table->enum('furnish', ['Semi furnished', 'Unfurnished'])->nullable();
            $table->decimal('harga', 15, 2); // Harga
            $table->string('lokasi');
            $table->string('kecamatan');
            $table->string('kota');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary');
    }
};
