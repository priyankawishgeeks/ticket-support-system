<?php

namespace Database\Seeders;
use App\Models\Plan;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlanAndSubscriptionSeeder extends Seeder
{
   public function run(): void
    {
        // Create a Professional Plan
        $professionalPlan = Plan::updateOrCreate(
            ['slug' => 'professional'],
            [
                'title' => 'Professional Plan',
                'border_color' => '#1E90FF',
                'title_color' => '#FFFFFF',
                'background_color' => '#007BFF',
                'badge_label' => 'Most Popular',
                'price' => 49.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'billing_cycle' => 'monthly',
                'trial_days' => 7,
                'max_users' => 10,
                'max_storage_gb' => 50,
                'max_projects' => 20,
                'renewal_type' => 'auto',
                'is_featured' => true,
                'is_active' => true,
                'features' => json_encode([
                    'max_tickets' => 500,
                    'priority_support' => true,
                    'analytics' => true,
                    'custom_reports' => true,
                ]),
            ]
        );

        // Create sample users
        $users = [
            [
                'username' => 'johndoe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'full_name' => 'John Doe',
                'gender' => 'Male',
                'status' => 'active',
            ],
            [
                'username' => 'janedoe',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'full_name' => 'Jane Doe',
                'gender' => 'Female',
                'status' => 'active',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(['email' => $userData['email']], $userData);

            // Create a subscription for each user
            Subscription::updateOrCreate(
                ['user_id' => $user->id, 'plan_id' => $professionalPlan->id],
                [
                    'status' => 'trial',
                    'amount' => $professionalPlan->price,
                    'currency' => $professionalPlan->currency,
                    'payment_method' => null,
                    'started_at' => now(),
                    'trial_ends_at' => now()->addDays($professionalPlan->trial_days),
                    'expires_at' => now()->addDays($professionalPlan->duration_days),
                    'renewal_type' => $professionalPlan->renewal_type,
                    'meta' => json_encode(['notes' => 'Seeded subscription']),
                ]
            );
        }
    }
}
