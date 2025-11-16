<?php

namespace Database\Seeders;

use App\Models\Dealer;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dealers = Dealer::all();

        foreach ($dealers as $index => $dealer) {
            // Vary the plans across dealers
            $plans = ['professional', 'enterprise', 'professional', 'starter'];
            $plan = $plans[$index] ?? 'professional';

            $limits = [
                'starter' => 25,
                'professional' => 100,
                'enterprise' => 999999,
            ];

            $prices = [
                'starter' => 99.00,
                'professional' => 299.00,
                'enterprise' => 599.00,
            ];

            Subscription::create([
                'dealer_id' => $dealer->id,
                'plan' => $plan,
                'vehicle_limit' => $limits[$plan],
                'monthly_price' => $prices[$plan],
                'status' => 'active',
                'started_at' => now()->subMonths(rand(1, 12)),
                'current_period_start' => now()->startOfMonth(),
                'current_period_end' => now()->endOfMonth(),
                'trial_ends_at' => null,
                'payment_method' => 'card',
            ]);
        }
    }
}
