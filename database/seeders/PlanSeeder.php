<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'title' => 'Professional Plan',
            'slug' => 'professional',
            'price' => 29.99,
            'duration_days' => 30,
            'billing_cycle' => 'monthly',
            'badge_label' => 'Most Popular',
            'border_color' => '#0d6efd',
            'title_color' => '#ffffff',
            'background_color' => '#e7f1ff',
            'features' => [
                'max_users' => 5,
                'max_projects' => 50,
                'max_storage_gb' => 10,
                'support' => 'Priority support',
                'analytics' => true,
                'ads_free' => true,
            ],
            'trial_days' => 7,
            'is_featured' => true,
        ]);
    }
}
