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
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->string('nama_konsumen');
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->string('domisili')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('nama_kantor')->nullable();
            $table->string('perumahan')->nullable();
            $table->date('tanggal_janjian')->nullable();
            $table->time('waktu_janjian')->nullable();
            $table->string('sumber_informasi')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
