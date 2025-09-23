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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->date('payment_date');
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['rent', 'deposit', 'electricity', 'water', 'other'])->default('rent');
            $table->enum('status', ['paid', 'pending', 'overdue'])->default('pending');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable(); // Hạn thanh toán
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function delete(): void
    {
        Schema::dropIfExists('payments');
    }
};