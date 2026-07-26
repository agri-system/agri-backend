<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remunerations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('worker_id')->constrained('workers')->restrictOnDelete();
            // 1 to 12
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('days_worked');
            $table->unsignedInteger('objectives_met');
            $table->decimal('calculated_amount', 10, 2);
            // pending, paid
            $table->string('payment_status', 20)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remunerations');
    }
};
