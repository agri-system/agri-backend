<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('stock_id')->constrained('stocks')->restrictOnDelete();
            // in, out, loss
            $table->string('movement_type', 20);
            $table->decimal('quantity', 10, 2);
            $table->date('movement_date');
            $table->foreignUlid('user_id')->constrained('users')->restrictOnDelete();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
