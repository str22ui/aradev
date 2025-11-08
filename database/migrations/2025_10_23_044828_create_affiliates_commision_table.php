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
        Schema::create('affiliates_commision', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id'); // relasi ke tabel affiliates
            $table->string('bulan');
            $table->decimal('harga_pricelist', 15, 2);
            $table->decimal('biaya_legalitas', 15, 2);
            $table->decimal('net_price', 15, 2);
            $table->decimal('fee_2_5', 15, 2);
            $table->decimal('fee_affiliate_30', 15, 2);
            $table->decimal('sub_total_bulanan', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();

            // Foreign key ke tabel affiliates
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliates_commision');
    }
};
