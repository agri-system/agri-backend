<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_activities', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('field_id')->constrained('fields')->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained('users')->restrictOnDelete();
            // sowing, maintenance, treatment
            $table->string('activity_type', 30);
            $table->date('activity_date');
            $table->json('details')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_activities');
    }
};
