<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('full_name', 150)->nullable();
            $table->string('title', 50)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('profile_img')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Other');
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Pending'])->default('Pending');
            $table->boolean('is_enable_chat')->default(false);
            $table->timestamps();
        });

       
    }

    public function down(): void
    {
       
        Schema::dropIfExists('users');
    }
};
