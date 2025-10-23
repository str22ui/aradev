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
        Schema::create('affiliate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('referred_by_admin')->nullable()->constrained('admins');
            $table->foreignId('referred_by_agent')->nullable()->constrained('agents');
            $table->foreignId('referred_by_sales')->nullable()->constrained('sales');
            $table->decimal('commission_rate', 5, 2)->default(0.00);
            $table->decimal('total_sales', 15, 2)->default(0.00);
            $table->decimal('total_commission', 15, 2)->default(0.00);
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate');
    }
};
