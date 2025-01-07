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
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->string('domisili');
            $table->string('pekerjaan')->nullable();
            $table->string('nama_kantor')->nullable();
            $table->string('sumber_informasi')->nullable();
            $table->foreignId('perumahan_id')->constrained('perumahan')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            $table->string('payment');
            $table->string('income'); // Untuk menyimpan angka dengan dua desimal
            $table->string('dp');     // DP (Down Payment) juga dengan dua desimal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran');
    }
};
