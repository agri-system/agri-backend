<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('last_name', 100);
            $table->string('first_name', 100);
            $table->string('username', 80)->nullable()->unique();
            $table->string('email')->unique();
            $table->string('phone', 30)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar_path')->nullable();
            // No password at creation: the user sets their own through the activation link.
            $table->string('password')->nullable();
            $table->foreignUlid('role_id')->constrained('roles')->restrictOnDelete();
            // pending, active, inactive
            $table->string('status', 20)->default('pending');
            // web, mobile, both — checked against the "platform" the login request comes from.
            $table->string('platform_access', 10)->default('web');
            // single-use, expiring link sent by email at account creation; the user sets
            // their own password through it. Nulled out once the account is activated.
            $table->string('activation_token', 64)->nullable()->unique();
            $table->timestamp('activation_token_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id', 26)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
