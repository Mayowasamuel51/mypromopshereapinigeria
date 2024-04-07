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
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('id_number');
            $table->integer('current_plan')->nullable();
            $table->string('country')->nullable();
            $table->string('location')->nullable();
            $table->string('websiteName')->nullable();
            $table->string('brandName')->nullable();
            $table->string('messageCompany')->nullable();
            $table->string('aboutMe')->nullable();
            $table->string('profileImage')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
