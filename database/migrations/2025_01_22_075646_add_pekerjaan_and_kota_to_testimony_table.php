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
        Schema::table('testimony', function (Blueprint $table) {
            //
            $table->string('pekerjaan')->nullable()->after('image');
            $table->string('kota')->nullable()->after('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimony', function (Blueprint $table) {
            //
            $table->dropColumn(['pekerjaan', 'kota']);
        });
    }
};
