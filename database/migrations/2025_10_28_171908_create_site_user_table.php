<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('site_user', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT

            // Basic Info
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique();
            $table->string('password');

            // Verification & Auth
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();

            // Personal Details
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('age')->unsigned()->virtualAs('TIMESTAMPDIFF(YEAR, dob, CURDATE())');
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('country', 3)->nullable();

            // Profile Info
            $table->string('profile_url', 255)->nullable();
            $table->string('photo_url', 255)->nullable();
            $table->text('bio')->nullable();
            $table->string('website', 255)->nullable();

            // Social & Login
            $table->enum('login_type', ['Normal','Facebook','Google','Twitter','LinkedIn','GitHub','Apple'])->default('Normal');
            $table->string('social_id', 255)->nullable();
            $table->json('social_data')->nullable();

            // Account Status
            $table->enum('status', ['Active','Inactive','Locked','Suspended'])->default('Active');
            $table->enum('user_type', ['Guest','User','Admin'])->default('User');

            // Activity & Metadata
            $table->string('timezone', 100)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_ip', 45)->nullable();
            $table->string('device_info', 255)->nullable();
            $table->timestamp('join_date')->useCurrent();

            // Laravel conventions
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at

            $table->index(['email', 'username']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_user');
    }
};
