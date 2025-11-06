<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expired_subscriptions', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();

            // Basic Info
            $table->string('plan_title', 150)->nullable();
            $table->string('plan_slug', 100)->nullable();
            $table->string('currency', 10)->default('USD');
            $table->decimal('amount', 10, 2)->default(0.00);

            // Dates
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('expired_at')->nullable(); // actual timestamp of expiration
            $table->dateTime('renewal_attempted_at')->nullable();

            // Renewal and retry info
            $table->enum('renewal_type', ['auto', 'manual'])->default('auto');
            $table->boolean('renewal_attempted')->default(false);
            $table->boolean('renewal_successful')->default(false);
            $table->unsignedInteger('retry_count')->default(0);
            $table->unsignedInteger('max_retries')->default(3);
            $table->dateTime('next_retry_at')->nullable();

            // Payment details
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference', 150)->nullable();
            $table->string('invoice_number', 100)->nullable();
            $table->decimal('last_payment_amount', 10, 2)->nullable();
            $table->dateTime('last_payment_date')->nullable();
            $table->enum('last_payment_status', [
                'pending',
                'successful',
                'failed',
                'refunded'
            ])->nullable();

            // Status and reason
            $table->enum('status', [
                'expired',
                'cancelled',
                'grace_period',
                'renewal_failed',
                'archived'
            ])->default('expired');

            $table->text('expiry_reason')->nullable(); // e.g. "Payment failed", "User cancelled"
            $table->text('admin_notes')->nullable();

            // Meta and tracking
            $table->json('meta')->nullable();
            $table->json('gateway_response')->nullable();
            $table->boolean('notified_user')->default(false);
            $table->dateTime('notified_at')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expired_subscriptions');
    }
};
