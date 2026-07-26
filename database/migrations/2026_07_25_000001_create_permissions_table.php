<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // sites, fields, stocks, sales, expenses, workers, users, ...
            $table->string('module', 50);
            // read, create, update, delete
            $table->string('action', 50);
            $table->string('description', 255)->nullable();
            $table->unique(['module', 'action']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
