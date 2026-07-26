<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('site_id')->constrained('sites')->restrictOnDelete();
            $table->foreignUlid('field_id')->nullable()->constrained('fields')->nullOnDelete();
            $table->string('crop', 100)->nullable();
            // input, labor, treatment, maintenance, transport, other
            $table->string('category', 30);
            $table->text('description');
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->foreignUlid('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignUlid('need_id')->nullable()->constrained('agricultural_needs')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
