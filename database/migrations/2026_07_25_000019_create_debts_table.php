<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignUlid('client_id')->constrained('clients')->restrictOnDelete();
            $table->decimal('amount_due', 10, 2);
            $table->date('due_date');
            $table->date('reminder_date')->nullable();
            // pending, reminded, collected
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
