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
        Schema::table('secondary', function (Blueprint $table) {
            $table->string('hadap')->nullable()->after('imb'); // Sesuaikan posisi kolom dengan `after`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secondary', function (Blueprint $table) {
            //
        });
    }
};
