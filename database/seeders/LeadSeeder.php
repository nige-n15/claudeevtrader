<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::with('dealer')->get();

        $leadTemplates = [
            [
                'customer_name' => 'John Smith',
                'customer_email' => 'john.smith@email.com',
                'customer_phone' => '07700 900123',
                'customer_postcode' => 'SW1A 1AA',
                'type' => 'inquiry',
                'message' => 'Hi, I\'m interested in this vehicle. Is it still available? Can I arrange a viewing this weekend?',
                'contact_preference' => 'phone',
                'status' => 'new',
            ],
            [
                'customer_name' => 'Emma Johnson',
                'customer_email' => 'emma.j@email.com',
                'customer_phone' => '07700 900456',
                'customer_postcode' => 'M1 1AA',
                'type' => 'test_drive',
                'message' => 'Would like to book a test drive for this weekend if possible.',
                'contact_preference' => 'email',
                'status' => 'contacted',
                'contacted_at' => now()->subHours(2),
            ],
            [
                'customer_name' => 'Michael Brown',
                'customer_email' => 'mbrown@email.com',
                'customer_phone' => '07700 900789',
                'customer_postcode' => 'B1 1AA',
                'type' => 'inquiry',
                'message' => 'Interested in part exchange. I have a 2019 Audi A4.',
                'contact_preference' => 'either',
                'has_part_exchange' => true,
                'part_exchange_details' => [
                    'make' => 'Audi',
                    'model' => 'A4',
                    'year' => 2019,
                    'mileage' => 45000,
                ],
                'status' => 'qualified',
                'contacted_at' => now()->subDays(1),
                'qualified_at' => now()->subHours(12),
            ],
            [
                'customer_name' => 'Sarah Davis',
                'customer_email' => 'sarah.d@email.com',
                'customer_phone' => '07700 900321',
                'customer_postcode' => 'EH1 1AA',
                'type' => 'reservation',
                'message' => 'Ready to reserve. Can you hold this for 48 hours?',
                'contact_preference' => 'phone',
                'finance_interested' => true,
                'finance_deposit' => 5000,
                'finance_term_months' => 48,
                'status' => 'negotiating',
                'contacted_at' => now()->subDays(2),
                'qualified_at' => now()->subDays(1),
            ],
            [
                'customer_name' => 'David Wilson',
                'customer_email' => 'david.w@email.com',
                'customer_phone' => null,
                'customer_postcode' => 'SW1A 2AA',
                'type' => 'email',
                'message' => 'What\'s your best price on this? I\'m a cash buyer.',
                'contact_preference' => 'email',
                'status' => 'new',
            ],
        ];

        foreach ($vehicles as $index => $vehicle) {
            // Add 1-3 leads per vehicle
            $numLeads = rand(1, min(3, count($leadTemplates)));

            for ($i = 0; $i < $numLeads; $i++) {
                $template = $leadTemplates[($index + $i) % count($leadTemplates)];

                Lead::create(array_merge($template, [
                    'vehicle_id' => $vehicle->id,
                    'dealer_id' => $vehicle->dealer_id,
                    'source' => 'platform',
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Mozilla/5.0',
                    'referrer' => 'https://google.com',
                ]));
            }
        }
    }
}
