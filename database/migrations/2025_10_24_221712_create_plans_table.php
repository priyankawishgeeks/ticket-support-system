<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 150);
            $table->string('slug', 100)->unique(); // e.g., "basic", "professional"

            // UI colors and styling
            $table->string('border_color', 20)->default('#007bff');
            $table->string('title_color', 20)->default('#000000');
            $table->string('background_color', 20)->default('#f8f9fa');
            $table->string('badge_label', 50)->nullable(); // e.g., "Most Popular"

            // Billing and pricing
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('currency', 10)->default('USD');
            $table->unsignedInteger('duration_days')->default(30);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one-time'])->default('monthly');

            // JSON and limits
            $table->json('features')->nullable();
            $table->unsignedInteger('trial_days')->default(0);
            $table->unsignedInteger('max_users')->nullable();
            $table->unsignedInteger('max_storage_gb')->nullable();
            $table->unsignedInteger('max_projects')->nullable();

            // Meta info
            $table->enum('renewal_type', ['auto', 'manual'])->default('auto');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
