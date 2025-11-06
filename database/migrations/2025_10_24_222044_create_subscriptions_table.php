<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');

            // Core status and billing
            $table->enum('status', ['active','cancelled','expired','pending','trial'])->default('pending');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('currency', 10)->default('USD');
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference', 100)->nullable();

            // Time tracking
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('renewed_at')->nullable();

            // Usage / meta
            $table->enum('renewal_type', ['auto','manual'])->default('auto');
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
