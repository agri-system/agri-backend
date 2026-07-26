<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_lots', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('field_id')->constrained('fields')->restrictOnDelete();
            $table->string('crop', 100);
            $table->string('lot_code', 50)->unique();
            $table->date('creation_date');
            // open, closed
            $table->string('status', 20)->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_lots');
    }
};
