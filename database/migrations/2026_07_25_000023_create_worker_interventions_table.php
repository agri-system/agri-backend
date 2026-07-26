<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_interventions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('worker_id')->constrained('workers')->cascadeOnDelete();
            $table->foreignUlid('field_id')->constrained('fields')->restrictOnDelete();
            $table->foreignUlid('user_id')->constrained('users')->restrictOnDelete();
            $table->date('intervention_date');
            $table->string('work_type', 100);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('objective_met');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_interventions');
    }
};
