<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('plan_id');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('currency', 10)->default('USD');
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference', 150)->nullable();
            $table->string('invoice_number', 100)->nullable();
            $table->string('payment_intent_id', 150)->nullable();
            $table->enum('status', [
                'pending',
                'processing',
                'successful',
                'failed',
                'refunded',
                'cancelled',
                'expired',
            ])->default('pending');
            $table->enum('payment_type', [
                'initial',
                'renewal',
                'upgrade',
                'downgrade',
                'manual',
            ])->default('initial');
            $table->boolean('renewal_attempt')->default(false);
            $table->dateTime('payment_due_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->dateTime('next_retry_at')->nullable();
            $table->unsignedInteger('retry_count')->default(0);
            $table->unsignedInteger('max_retries')->default(3);
            $table->json('gateway_response')->nullable();
            $table->json('meta')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('subscription_payments');
    }
};
