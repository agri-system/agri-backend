<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_calendar', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('field_id')->constrained('fields')->cascadeOnDelete();
            $table->string('crop', 100);
            // sowing, treatment, planned_harvest
            $table->string('stage', 30);
            $table->date('planned_date');
            // planned, completed, cancelled
            $table->string('status', 20)->default('planned');
            $table->text('notes')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_calendar');
    }
};
