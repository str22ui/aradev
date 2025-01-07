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
        Schema::table('penawaran', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('rumah_id')->nullable()->after('id'); // Tambahkan kolom rumah_id
        $table->foreign('rumah_id')->references('id')->on('rumah')->onDelete('cascade'); // Relasi dengan tabel rumah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            //
        $table->dropForeign(['rumah_id']); // Hapus foreign key
        $table->dropColumn('rumah_id');
        });
    }
};
