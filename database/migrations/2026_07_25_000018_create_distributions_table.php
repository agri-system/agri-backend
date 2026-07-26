<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('lot_id')->constrained('production_lots')->restrictOnDelete();
            $table->foreignUlid('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignUlid('source_site_id')->constrained('sites')->restrictOnDelete();
            $table->foreignUlid('destination_site_id')->constrained('sites')->restrictOnDelete();
            $table->foreignUlid('user_id')->constrained('users')->restrictOnDelete();
            $table->decimal('quantity', 10, 2);
            // basket, net, kilogram, bag, crate, ...
            $table->string('unit', 50);
            $table->date('distribution_date');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
