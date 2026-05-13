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
        Schema::create('adm_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'editor', 'viewer'])->default('admin');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->ipAddress('last_login_ip')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('login_attempts')->default(0);
            $table->integer('failed_login_attempts')->default(0);
            $table->integer('max_login_attempts')->default(5);
            $table->integer('lockout_duration')->default(15); // in minutes
            $table->integer('is_locked')->default(0);
            $table->integer('is_deleted')->default(0);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('lockout_time')->nullable();
            $table->timestamp('account_expires_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamp('password_expires_at')->nullable();
            $table->timestamp('password_last_changed_at')->nullable();
            $table->timestamp('account_created_at')->nullable();
            $table->timestamp('account_updated_at')->nullable();
            $table->timestamp('account_deleted_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->index('email');
            $table->index('mobile');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
            $table->index('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_users');
    }
};
