<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agricultural_needs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('field_id')->constrained('fields')->restrictOnDelete();
            $table->string('crop', 100);
            // input, labor, treatment, maintenance, transport, other
            $table->string('category', 30);
            $table->text('description');
            $table->decimal('estimated_quantity', 10, 2)->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->date('planned_date')->nullable();
            // urgent, high, normal, low
            $table->string('priority', 20)->default('normal');
            // planned, completed, cancelled
            $table->string('status', 20)->default('planned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agricultural_needs');
    }
};
