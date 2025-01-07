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
        Schema::table('perumahan', function (Blueprint $table) {
            $table->text('tipe')->nullable(); // Menambahkan kolom 'tipe' dengan tipe data text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perumahan', function (Blueprint $table) {
            $table->dropColumn('tipe'); // Menghapus kolom 'tipe' jika migrasi di-rollback
        });
    }
};
