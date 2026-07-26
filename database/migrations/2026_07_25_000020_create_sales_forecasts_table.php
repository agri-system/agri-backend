<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_forecasts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('crop', 100);
            // 1 to 12
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->decimal('planned_quantity', 10, 2)->nullable();
            $table->decimal('forecasted_revenue', 10, 2);
            $table->decimal('actual_revenue', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_forecasts');
    }
};
