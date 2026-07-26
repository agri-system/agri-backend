<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_objectives', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('worker_id')->constrained('workers')->cascadeOnDelete();
            // week number, 1 to 52
            $table->unsignedTinyInteger('week');
            $table->unsignedSmallInteger('year');
            $table->string('work_type', 100);
            $table->decimal('target_quantity', 10, 2)->nullable();
            $table->foreignUlid('field_id')->constrained('fields')->restrictOnDelete();
            // in_progress, met, not_met
            $table->string('status', 20)->default('in_progress');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_objectives');
    }
};
