<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPayment;
use Illuminate\Support\Carbon;

class SubscriptionPaymentsSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPayment::insert([
            [
                'user_id' => 2,
                'subscription_id' => 1,
                'plan_id' => 1,
                'amount' => 29.99,
                'currency' => 'USD',
                'payment_method' => 'stripe',
                'payment_reference' => 'pi_abc123',
                'invoice_number' => 'INV-1001',
                'status' => 'successful',
                'payment_type' => 'initial',
                'paid_at' => Carbon::now(),
                'gateway_response' => json_encode(['gateway' => 'stripe', 'status' => 'succeeded']),
                'meta' => json_encode(['ip' => '127.0.0.1']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'subscription_id' => 2,
                'plan_id' => 2,
                'amount' => 49.99,
                'currency' => 'USD',
                'payment_method' => 'paypal',
                'payment_reference' => 'txn_987xyz',
                'status' => 'pending',
                'payment_due_at' => Carbon::now()->addDays(2),
                'gateway_response' => json_encode(['gateway' => 'paypal', 'status' => 'pending']),
                'meta' => json_encode(['attempt' => 1]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
