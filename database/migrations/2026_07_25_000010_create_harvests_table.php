<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('field_id')->constrained('fields')->restrictOnDelete();
            $table->foreignUlid('lot_id')->constrained('production_lots')->restrictOnDelete();
            $table->foreignUlid('user_id')->constrained('users')->restrictOnDelete();
            $table->date('harvest_date');
            $table->decimal('estimated_quantity', 10, 2)->nullable();
            $table->decimal('actual_quantity', 10, 2);
            // basket, net, kilogram, bag, crate, ...
            $table->string('unit', 50);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};
