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
        Schema::create('adm_user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('timezone')->nullable();
            $table->string('language')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->foreign('user_id')->references('id')->on('adm_users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('created_at');
            $table->index('updated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_user_details');
    }
};
