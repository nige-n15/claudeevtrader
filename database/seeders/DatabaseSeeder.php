<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DealerSeeder::class,        // Creates dealers and users
            SubscriptionSeeder::class,  // Creates subscriptions
            VehicleSeeder::class,       // Creates vehicles and images
            LeadSeeder::class,          // Creates leads
        ]);
    }
}
