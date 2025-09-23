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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('deposit', 12, 2); // Tiền cọc
            $table->decimal('monthly_rent', 12, 2); // Tiền thuê hàng tháng
            $table->enum('status', ['active', 'expired', 'terminated'])->default('active');
            $table->text('terms')->nullable(); // Điều khoản hợp đồng
            $table->text('notes')->nullable(); // Ghi chú
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function delete(): void
    {
        Schema::dropIfExists('contracts');
    }
};
