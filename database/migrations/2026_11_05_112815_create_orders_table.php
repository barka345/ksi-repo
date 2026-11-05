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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no', 32)->unique();
            $table->foreignId('outled_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->string('costumer_name');
            $table->string('costumer_phone', 30);
            $table->enum('status', ['received', 'washing', 'drying', 'ironing', 'ready', 'completed', 'cancelled'])->default('received');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid']);
            $table->unsignedInteger('total_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
